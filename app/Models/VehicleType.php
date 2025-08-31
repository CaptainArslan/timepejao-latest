<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'has_ac',
        'has_wifi',
        'has_tv',
        'has_charging',
        'has_wheelchair_access',
        'seating_capacity',
        'standing_capacity',
        'max_capacity',
        'is_active',
    ];

    protected $casts = [
        'has_ac' => 'boolean',
        'has_wifi' => 'boolean',
        'has_tv' => 'boolean',
        'has_charging' => 'boolean',
        'has_wheelchair_access' => 'boolean',
        'is_active' => 'boolean',
        'seating_capacity' => 'integer',
        'standing_capacity' => 'integer',
        'max_capacity' => 'integer',
    ];

    // =============================== Relationships ===============================

    // =============================== End of Relationships ===============================

    // =============================== Accessors & Mutators ===============================

    // =============================== End of Accessors & Mutators ===============================

    // =============================== End of Model ===============================
}
