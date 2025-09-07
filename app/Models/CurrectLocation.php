<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CurrectLocation extends Model
{
    /** @use HasFactory<\Database\Factories\CurrectLocationFactory> */
    use HasFactory;

    protected $fillable = [
        'locationable_id',
        'locationable_type',
        'latitude',
        'longitude',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'location_updated_at',
        'metadata',
    ];

    // =============================== Relationships ===============================
    public function locationable(): MorphTo
    {
        return $this->morphTo();
    }
    // =============================== End of Relationships ===============================
}
