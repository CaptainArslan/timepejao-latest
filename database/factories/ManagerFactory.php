<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manager>
 */
class ManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $email = $this->faker->unique()->safeEmail();
        $password = Hash::make('password');

        return [
            'full_name' => $this->faker->name(),
            'email' => $email,
            'password' => $password,
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'image_url' => $this->faker->imageUrl(),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
