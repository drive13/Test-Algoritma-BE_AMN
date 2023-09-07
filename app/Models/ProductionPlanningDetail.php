<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPlanningDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_planning_id',
        'production_date',
        'qty',
    ];
}
