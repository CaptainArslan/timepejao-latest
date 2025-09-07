<?php

namespace Database\Seeders;

use App\Models\TransportRoute;
use Illuminate\Database\Seeder;

class TransportRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransportRoute::factory()->count(100)->create();
    }
}
