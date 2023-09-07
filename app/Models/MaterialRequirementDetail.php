<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequirementDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_requirement_id',
        'part_id',
        'qty',
    ];
}
