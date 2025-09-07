<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportRoute extends Model
{
    /** @use HasFactory<\Database\Factories\TransportRouteFactory> */
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'number',
        'description',
        'from_address',
        'to_address',
        'notes',
        'image',
        'waypoints',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'from_address' => 'array',
        'to_address' => 'array',
        'waypoints' => 'array',
    ];

    // =============================== Relationships ===============================

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    // =============================== End of Relationships ===============================

    // =============================== Accessors & Mutators ===============================

    // =============================== End of Accessors & Mutators ===============================

    // =============================== End of Model ===============================
}
