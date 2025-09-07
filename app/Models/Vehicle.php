<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;

    protected $fillable = [
        'vehicle_type_id',
        'organization_id',
        'registration_number',
        'vin',
        'chassis_number',
        'license_plate',
        'make',
        'model',
        'year',
        'color',
        'seating_capacity',
        'standing_capacity',
        'max_capacity',
        'notes',
        'image_url',
        'front_image',
        'back_image',
        'additional_images',
    ];

    protected $casts = [
        'seating_capacity' => 'integer',
        'standing_capacity' => 'integer',
        'max_capacity' => 'integer',
        'additional_images' => 'array',
    ];

    // =============================== Relationships ===============================

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    // =============================== End of Relationships ===============================

    // =============================== Accessors & Mutators ===============================

    // ✅ Images accessor
    protected function allImages(): Attribute
    {
        return Attribute::get(function () {
            $images = [];

            if ($this->image_url) {
                $images['main'] = $this->image_url;
            }
            if ($this->front_image) {
                $images['front'] = $this->front_image;
            }
            if ($this->back_image) {
                $images['back'] = $this->back_image;
            }
            if ($this->additional_images) {
                $images['additional'] = $this->additional_images;
            }

            return $images;
        });
    }

    // ✅ Full name accessor
    protected function fullName(): Attribute
    {
        return Attribute::get(function () {
            $parts = [];

            if ($this->year) {
                $parts[] = $this->year;
            }
            if ($this->make) {
                $parts[] = $this->make;
            }
            if ($this->model) {
                $parts[] = $this->model;
            }

            return $parts ? implode(' ', $parts) : 'Vehicle #'.$this->id;
        });
    }

    // =============================== End of Accessors & Mutators ===============================

    // =============================== End of Model ===============================
}
