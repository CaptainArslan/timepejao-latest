<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationType extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_class',
        'end_class',
    ];

    protected $casts = [
        'start_class' => 'integer',
        'end_class' => 'integer',
    ];

    // =============================== Relationships ===============================
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
    // =============================== End of Relationships ===============================
}
