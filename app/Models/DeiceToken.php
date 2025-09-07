<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DeiceToken extends Model
{
    /** @use HasFactory<\Database\Factories\DeiceTokenFactory> */
    use HasFactory;

    protected $fillable = [
        'tokenable_id',
        'tokenable_type',
        'token',
        'device_identifier',
    ];

    // =============================== Relationships ===============================
    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }
    // =============================== End of Relationships ===============================
}
