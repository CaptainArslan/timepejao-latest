<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::inRandomOrder()->first()->id,
            'full_name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'driver_license_number' => $this->faker->unique()->randomNumber(8),
            'license_class' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'license_issue_date' => $this->faker->date(),
            'license_expiry_date' => $this->faker->date(),
            'is_active' => $this->faker->boolean(),
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_phone' => $this->faker->phoneNumber(),
            'emergency_contact_relationship' => $this->faker->randomElement(['Spouse', 'Parent', 'Child', 'Friend']),
            'profile_image' => $this->faker->imageUrl(),
            'license_front_image' => $this->faker->imageUrl(),
            'license_back_image' => $this->faker->imageUrl(),
            'id_card_front_image' => $this->faker->imageUrl(),
            'id_card_back_image' => $this->faker->imageUrl(),
            'passport_image' => $this->faker->imageUrl(),
            'rating' => $this->faker->randomFloat(2, 0, 5),
            'total_trips' => $this->faker->numberBetween(0, 100),
            'total_distance' => $this->faker->numberBetween(0, 100000),
            'accidents_count' => $this->faker->numberBetween(0, 10),
            'violations_count' => $this->faker->numberBetween(0, 10),
        ];
    }
}
