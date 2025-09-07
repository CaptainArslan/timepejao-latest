<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Manager extends Model
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\ManagerFactory> */
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'organization_id',
        'full_name',
        'email',
        'phone',
        'gender',
        'image_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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

    public function currectLocation(): MorphOne
    {
        return $this->morphOne(CurrectLocation::class, 'locationable');
    }

    public function deiceTokens(): MorphMany
    {
        return $this->morphMany(DeiceToken::class, 'tokenable');
    }

    // =============================== End of Relationships ===============================

    // =============================== Accessors & Mutators ===============================

    // =============================== End of Accessors & Mutators ===============================

    // =============================== End of Model ===============================
}
