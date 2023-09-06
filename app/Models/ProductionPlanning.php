<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPlanning extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'planned_qty',
        'daily_capacity',
        'plan_date',
    ];
}
