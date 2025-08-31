<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Organization extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'branch_code',
        'code',
        'description',
        'tagline',
        'email',
        'phone',
        'website',
        'organization_type_id',
        'is_active',
        'logo_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    // =============================== Relationships ===============================
    public function organizationType(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function defaultAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')->where('is_default', true);
    }

    public function manager(): HasOne
    {
        return $this->hasOne(Manager::class);
    }

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    // =============================== End of Relationships ===============================

    // =============================== Accessors & Mutators ===============================

    // =============================== End of Accessors & Mutators ===============================

    // =============================== End of Model ===============================
}
