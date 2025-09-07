<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Passenger>
 */
class PassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isVerified = $this->faker->boolean(70); // 70% chance of being verified

        return [
            'organization_id' => Organization::inRandomOrder()->first()->id,
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'national_id' => $this->faker->unique()->numerify('##########'),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
            'is_verified' => $isVerified,
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_phone' => $this->faker->phoneNumber(),
            'emergency_contact_relationship' => $this->faker->randomElement(['Spouse', 'Parent', 'Child', 'Sibling', 'Friend', 'Other']),
            'profile_image' => $this->faker->optional(0.6)->imageUrl(200, 200, 'people'),
            'national_id_front_image' => $this->faker->optional(0.8)->imageUrl(400, 300, 'business'),
            'national_id_back_image' => $this->faker->optional(0.8)->imageUrl(400, 300, 'business'),
            'passport_image' => $this->faker->optional(0.3)->imageUrl(400, 300, 'business'),
            'preferences' => [
                'language' => $this->faker->randomElement(['en', 'es', 'fr', 'de', 'it', 'pt']),
                'music_preference' => $this->faker->randomElement(['none', 'soft', 'loud', 'any']),
                'conversation_preference' => $this->faker->randomElement(['none', 'light', 'moderate', 'heavy']),
                'temperature_preference' => $this->faker->randomElement(['cold', 'cool', 'moderate', 'warm', 'hot']),
                'smoking_preference' => $this->faker->randomElement(['no_smoking', 'smoking_allowed']),
            ],
            'preferred_language' => $this->faker->randomElement(['en', 'es', 'fr', 'de', 'it', 'pt']),
            'sms_notifications' => $this->faker->boolean(80),
            'email_notifications' => $this->faker->boolean(85),
            'push_notifications' => $this->faker->boolean(90),
        ];
    }

    /**
     * Indicate that the passenger is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified' => true,
        ]);
    }

    /**
     * Indicate that the passenger is unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified' => false,
        ]);
    }

    /**
     * Indicate that the passenger is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the passenger is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the passenger has all notifications enabled.
     */
    public function withAllNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'sms_notifications' => true,
            'email_notifications' => true,
            'push_notifications' => true,
        ]);
    }

    /**
     * Indicate that the passenger has no notifications enabled.
     */
    public function withoutNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'sms_notifications' => false,
            'email_notifications' => false,
            'push_notifications' => false,
        ]);
    }

    /**
     * Indicate that the passenger has documents uploaded.
     */
    public function withDocuments(): static
    {
        return $this->state(fn (array $attributes) => [
            'profile_image' => $this->faker->imageUrl(200, 200, 'people'),
            'national_id_front_image' => $this->faker->imageUrl(400, 300, 'business'),
            'national_id_back_image' => $this->faker->imageUrl(400, 300, 'business'),
            'passport_image' => $this->faker->imageUrl(400, 300, 'business'),
        ]);
    }
}
