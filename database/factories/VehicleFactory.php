<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_type_id' => VehicleType::inRandomOrder()->first()->id,
            'organization_id' => Organization::inRandomOrder()->first()->id,
            'registration_number' => $this->faker->unique()->randomNumber(8),
            'vin' => $this->faker->unique()->randomNumber(8),
            'chassis_number' => $this->faker->unique()->randomNumber(8),
            'license_plate' => $this->faker->unique()->randomNumber(8),
            'make' => $this->faker->company(),
            'model' => $this->faker->company(),
            'year' => $this->faker->year(),
            'color' => $this->faker->colorName(),
            'seating_capacity' => $this->faker->numberBetween(1, 100),
            'standing_capacity' => $this->faker->numberBetween(0, 100),
            'max_capacity' => $this->faker->numberBetween(1, 100),
            'notes' => $this->faker->sentence(),
            'image_url' => $this->faker->imageUrl(),
            'front_image' => $this->faker->imageUrl(),
            'back_image' => $this->faker->imageUrl(),
            'additional_images' => $this->faker->imageUrl(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
