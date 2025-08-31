<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
