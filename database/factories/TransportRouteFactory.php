<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransportRoute>
 */
class TransportRouteFactory extends Factory
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
            'name' => $this->faker->name(),
            'number' => $this->faker->unique()->randomNumber(8),
            'description' => $this->faker->sentence(),
            'from_address' => [
                'address' => $this->faker->address(),
                'country' => $this->faker->country(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
                'coordinates' => [
                    'latitude' => $this->faker->latitude(),
                    'longitude' => $this->faker->longitude(),
                ],
            ],
            'to_address' => [
                'address' => $this->faker->address(),
                'country' => $this->faker->country(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
                'coordinates' => [
                    'latitude' => $this->faker->latitude(),
                    'longitude' => $this->faker->longitude(),
                ],
                'longitude' => $this->faker->longitude(),
            ],
            'notes' => $this->faker->sentence(),
            'image' => $this->faker->imageUrl(),
            'waypoints' => [
                [
                    'address' => $this->faker->address(),
                    'country' => $this->faker->country(),
                    'city' => $this->faker->city(),
                    'state' => $this->faker->state(),
                    'postal_code' => $this->faker->postcode(),
                    'coordinates' => [
                        'latitude' => $this->faker->latitude(),
                        'longitude' => $this->faker->longitude(),
                    ],

                ],
                [
                    'address' => $this->faker->address(),
                    'country' => $this->faker->country(),
                    'city' => $this->faker->city(),
                    'state' => $this->faker->state(),
                    'postal_code' => $this->faker->postcode(),
                    'coordinates' => [
                        'latitude' => $this->faker->latitude(),
                        'longitude' => $this->faker->longitude(),
                    ],
                ],
            ],
            'is_active' => $this->faker->boolean(),
        ];
    }
}
