<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\OrganizationType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Added this import for the new generateUniqueCode method

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company();
        $initials = $this->generateInitials($name);

        return [
            'name' => $name,
            'alias' => $this->faker->unique()->word(),
            'branch_code' => $this->faker->unique()->word(),
            'code' => $this->generateUniqueCode($initials),
            'description' => $this->faker->sentence(),
            'tagline' => $this->faker->sentence(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->url(),
            'organization_type_id' => OrganizationType::inRandomOrder()->first()->id,
            'is_active' => $this->faker->boolean(),
            'logo_url' => $this->faker->imageUrl(),
        ];
    }

    /**
     * Generate initials from organization name.
     */
    private function generateInitials(string $name): string
    {
        // Remove spaces and special characters, take first 3 characters
        $cleanName = preg_replace('/[^a-zA-Z0-9]/', '', $name);
        $initials = strtoupper(substr($cleanName, 0, 3));

        return $initials ?: 'ORG';
    }

    /**
     * Generate unique alphanumeric code with organization initials.
     */
    private function generateUniqueCode(string $initials): string
    {
        // Generate 8 random alphanumeric characters
        $randomPart = strtoupper(Str::random(6));

        return $initials.'-'.$randomPart;
    }
}
