<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleType>
 */
class VehicleTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicleTypes = [
            'Bus' => ['seating' => 45, 'standing' => 15],
            'Mini Bus' => ['seating' => 25, 'standing' => 10],
            'Car' => ['seating' => 4, 'standing' => 0],
            'Van' => ['seating' => 12, 'standing' => 5],
            'SUV' => ['seating' => 7, 'standing' => 0],
            'Luxury Car' => ['seating' => 4, 'standing' => 0],
        ];

        $selectedType = $this->faker->randomElement(array_keys($vehicleTypes));
        $specs = $vehicleTypes[$selectedType];
        
        $name = $selectedType;
        $code = $this->generateVehicleCode($name);
        
        return [
            'name' => $name,
            'code' => $code,
            'description' => $this->faker->sentence(),
            'has_ac' => $this->faker->boolean(80), // 80% chance of having AC
            'has_wifi' => $this->faker->boolean(60), // 60% chance of having WiFi
            'has_tv' => $this->faker->boolean(40), // 40% chance of having TV
            'has_charging' => $this->faker->boolean(70), // 70% chance of having charging
            'has_wheelchair_access' => $this->faker->boolean(30), // 30% chance of wheelchair access
            'seating_capacity' => $specs['seating'],
            'standing_capacity' => $specs['standing'],
            'max_capacity' => $specs['seating'] + $specs['standing'],
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }

    /**
     * Generate unique vehicle type code.
     */
    private function generateVehicleCode(string $name): string
    {
        $initials = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $name), 0, 3));
        $randomPart = strtoupper(Str::random(4));
        return $initials . '-' . $randomPart;
    }
}
