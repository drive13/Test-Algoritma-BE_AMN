<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequirementBom extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_requirement_id',
        'bill_of_material_id',
    ];
}
