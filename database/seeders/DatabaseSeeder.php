<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(1)->create();

        $this->call([
            AdminSeeder::class,
            OrganizationTypeSeeder::class,
            OrganizationSeeder::class,
            DriverSeeder::class,
            PassengerSeeder::class,
            VehicleTypeSeeder::class,
            VehicleSeeder::class,
            TransportRouteSeeder::class,
        ]);
    }
}
