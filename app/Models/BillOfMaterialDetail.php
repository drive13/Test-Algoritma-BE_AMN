<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterialDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_of_material_id',
        'part_id',
        'qty',
        'cost',
    ];
}
