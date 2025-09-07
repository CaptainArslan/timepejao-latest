<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Passenger extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\PassengerFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'organization_id',
        'full_name',
        'email',
        'password',
        'phone',
        'gender',
        'date_of_birth',
        'national_id',
        'passport_number',
        'is_active',
        'is_verified',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'profile_image',
        'national_id_front_image',
        'national_id_back_image',
        'passport_image',
        'preferences',
        'preferred_language',
        'sms_notifications',
        'email_notifications',
        'push_notifications',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'date_of_birth' => 'date',
        'preferences' => 'array',
        'sms_notifications' => 'boolean',
        'email_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'password' => 'hashed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'national_id',
        'passport_number',
    ];

    // =============================== Relationships ===============================

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function defaultAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')->where('is_default', true);
    }

    public function currentLocation(): MorphOne
    {
        return $this->morphOne(CurrectLocation::class, 'locationable');
    }

    // =============================== End of Relationships ===============================

    // =============================== Accessors & Mutators ===============================

    /**
     * Get the passenger's age based on date of birth
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Get the passenger's full name with title
     */
    public function getFullNameWithTitleAttribute(): string
    {
        $title = match ($this->gender) {
            'male' => 'Mr.',
            'female' => 'Ms.',
            default => ''
        };

        return trim($title.' '.$this->full_name);
    }

    /**
     * Check if passenger is verified
     */
    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    // =============================== End of Accessors & Mutators ===============================

    // =============================== Scopes ===============================
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    public function scopeWithSmsNotifications($query)
    {
        return $query->where('sms_notifications', true);
    }

    public function scopeWithEmailNotifications($query)
    {
        return $query->where('email_notifications', true);
    }

    public function scopeWithPushNotifications($query)
    {
        return $query->where('push_notifications', true);
    }

    // =============================== End of Scopes ===============================

    // =============================== End of Model ===============================
}
