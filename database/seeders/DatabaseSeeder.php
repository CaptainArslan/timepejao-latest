<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;

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
            VehicleTypeSeeder::class,
            VehicleSeeder::class,
        ]);
    }
}
