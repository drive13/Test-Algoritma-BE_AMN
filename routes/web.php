<?php

use App\Models\BillOfMaterial;
use App\Models\MaterialRequirement;
use App\Models\MaterialRequirementDetail;
use App\Models\Product;
use App\Models\ProductionCapacity;
use App\Models\ProductionPlanning;
use App\Models\ProductionPlanningDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/production-planning', function () {
    $products = Product::all();
    $productionPlan = DB::table('production_plannings as pp')
        ->join('products as p', 'pp.product_id', '=', 'p.id')
        ->select('pp.plan_date', 'p.code', 'p.name', 'pp.daily_capacity', 'pp.planned_qty')
        ->get();

    $productionPlanDetails = DB::table('production_plannings as pp')
        ->join('production_planning_details as ppd', 'pp.id', '=', 'ppd.production_planning_id')
        ->join('products as p', 'pp.product_id', '=', 'p.id')
        ->select('p.code', 'p.name', 'ppd.production_date', 'ppd.qty')
        ->get();

    // dd($products);

    // return $planningData;

    return view('prod-plan', [
        'products' => $products,
        'productionPlan' => $productionPlan,
        'productionPlanDetails' => $productionPlanDetails,
    ]);
});

Route::post('/production-planning', function (Request $request) {

    /**----------------------------------------------------- */
    $pc = ProductionCapacity::select('capacity')->where('product_id', $request->product_id)->first();

    $capacity = $pc->capacity;
    $qty = $request->qty;

    DB::transaction(function () use ($request, $capacity, $qty) {
        $daysNeeded = 0;
        $productionPlan = ProductionPlanning::create([
            'product_id' => $request->product_id,
            'planned_qty' => $qty,
            'daily_capacity' => $capacity,
            'plan_date' => $request->start_date,
        ]);

        while ($qty > 0) {
            $dailyProduction = min($qty, $capacity);

            //tanggal production
            $date = $request->start_date;
            $date1 = str_replace('-', '/', $date);
            $tgl_pengerjaan = date('Y-m-d', strtotime($date1 . "+" . $daysNeeded . " days"));

            ProductionPlanningDetail::create([
                'production_planning_id' => $productionPlan->id,
                'production_date' => $tgl_pengerjaan,
                'qty' => $dailyProduction,
            ]);

            $qty -= $dailyProduction;
            $daysNeeded++;
        }
    });

    return redirect('/production-planning');
});

Route::get('/material-requirement', function () {
    /**
     *  Buatlah sebuah aplikasi, yang akan membuat data material requirement dengan mengkonsumsi 
     *   data dari Production Planning Detail & Bill of Material.
     */
    $pps = ProductionPlanning::all();

    //loop seluruh data dari production planning
    foreach ($pps as $pp) {
        //ambil data bill of material berdasarkan product_id
        $result = DB::table('bill_of_materials as bom')
            ->join('bill_of_material_details as bomd', 'bom.id', '=', 'bomd.bill_of_material_id')
            ->join('parts as p', 'bomd.part_id', '=', 'p.id')
            ->join('products as p2', 'bom.product_id', '=', 'p2.id')
            ->join('production_plannings as pps', 'p2.id', '=', 'pps.product_id')
            ->select('pps.id as pps_id', 'pps.plan_date as date', 'p2.code', 'p2.name as product_name', 'p2.code', 'p.name', 'p.unit', 'bomd.qty', 'bomd.cost', DB::raw('(bomd.qty * bomd.cost) as total_cost'))
            ->where('p2.id', 1)
            ->get();

        DB::transaction(function () use ($result) {
            $mr = MaterialRequirement::create([
                'production_planning_id' => $result->pps_id,
                'requirement_date' => $result->date,
            ]);

            MaterialRequirementDetail::create([
                'material_requirement_id' => $mr->id,
                'qty' => $result->qty,
            ]);
        });

        dd($result);

        $bom = BillOfMaterial::where('product_id', $pp->product_id)->get();
    }

    //ambil seluruh informasi part dan qty nya, masukan kedalam MaterialRequirementDetail.
    //Cara menghitung part:
    // total part = production_planning_detail.production_qty * bill_of_material_detail.qty

    //pastikan tidak ada part_id yang ganda untuk satu tanggal produksi. Jika part sudah ada, maka tambahkan qtynya

    //masukan juga informasi bom_id kedalam tabel MaterialRequirementBom


});
