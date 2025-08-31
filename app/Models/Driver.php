<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'full_name',
        'email',
        'phone',
        'gender',
        'driver_license_number',
        'license_class',
        'license_issue_date',
        'license_expiry_date',
        'is_active',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'profile_image',
        'license_front_image',
        'license_back_image',
        'id_card_front_image',
        'id_card_back_image',
        'passport_image',
        'rating',
        'total_trips',
        'total_distance',
        'accidents_count',
        'violations_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
        'total_trips' => 'integer',
        'total_distance' => 'integer',
        'accidents_count' => 'integer',
        'violations_count' => 'integer',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'total_trips',
        'total_distance',
        'accidents_count',
        'violations_count',
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
