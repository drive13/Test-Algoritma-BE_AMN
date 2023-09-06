<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_planning_id',
        'requirement_date',
    ];
}
