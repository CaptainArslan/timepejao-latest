<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Organization;
use App\Models\Passenger;
use App\Models\Schedule;
use App\Models\TransportRoute;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting schedule seeding...');

        // Ensure we have the required related data
        $this->command->info('Checking required data...');

        // Check if we have organizations
        if (Organization::count() === 0) {
            $this->command->warn('No organizations found. Creating one...');
            Organization::factory()->create();
        }

        // Check if we have transport routes
        if (TransportRoute::count() === 0) {
            $this->command->warn('No transport routes found. Creating one...');
            TransportRoute::factory()->create();
        }

        // Check if we have vehicles
        if (Vehicle::count() === 0) {
            $this->command->warn('No vehicles found. Creating one...');
            Vehicle::factory()->create();
        }

        // Check if we have drivers
        if (Driver::count() === 0) {
            $this->command->warn('No drivers found. Creating one...');
            Driver::factory()->create();
        }

        // Check if we have passengers
        if (Passenger::count() === 0) {
            $this->command->warn('No passengers found. Creating one...');
            Passenger::factory()->create();
        }

        $this->command->info('Required data check completed.');

        // Create a mix of different types of schedules
        $scheduleCounts = [
            'regular' => 200,           // Regular schedules
            'published' => 150,         // Published schedules
            'completed' => 100,         // Completed schedules
            'cancelled' => 30,          // Cancelled schedules
            'delayed' => 50,            // Delayed schedules
            'in_progress' => 40,        // In progress schedules
            'today' => 25,              // Today's schedules
            'tomorrow' => 30,           // Tomorrow's schedules
            'next_week' => 50,          // Next week's schedules
            'high_capacity' => 35,      // High capacity schedules
            'long_distance' => 40,     // Long distance schedules
            'short_distance' => 60,    // Short distance schedules
        ];

        // Create regular schedules
        $this->command->info('Creating regular schedules...');
        Schedule::factory()
            ->count($scheduleCounts['regular'])
            ->create();

        // Create published schedules
        $this->command->info('Creating published schedules...');
        Schedule::factory()
            ->published()
            ->count($scheduleCounts['published'])
            ->create();

        // Create completed schedules
        $this->command->info('Creating completed schedules...');
        Schedule::factory()
            ->completed()
            ->count($scheduleCounts['completed'])
            ->create();

        // Create cancelled schedules
        $this->command->info('Creating cancelled schedules...');
        Schedule::factory()
            ->cancelled()
            ->count($scheduleCounts['cancelled'])
            ->create();

        // Create delayed schedules
        $this->command->info('Creating delayed schedules...');
        Schedule::factory()
            ->delayed()
            ->count($scheduleCounts['delayed'])
            ->create();

        // Create in-progress schedules
        $this->command->info('Creating in-progress schedules...');
        Schedule::factory()
            ->inProgress()
            ->count($scheduleCounts['in_progress'])
            ->create();

        // Create today's schedules
        $this->command->info('Creating today\'s schedules...');
        Schedule::factory()
            ->today()
            ->published()
            ->count($scheduleCounts['today'])
            ->create();

        // Create tomorrow's schedules
        $this->command->info('Creating tomorrow\'s schedules...');
        Schedule::factory()
            ->tomorrow()
            ->published()
            ->count($scheduleCounts['tomorrow'])
            ->create();

        // Create next week's schedules
        $this->command->info('Creating next week\'s schedules...');
        Schedule::factory()
            ->nextWeek()
            ->published()
            ->count($scheduleCounts['next_week'])
            ->create();

        // Create high capacity schedules
        $this->command->info('Creating high capacity schedules...');
        Schedule::factory()
            ->highCapacity()
            ->published()
            ->count($scheduleCounts['high_capacity'])
            ->create();

        // Create long distance schedules
        $this->command->info('Creating long distance schedules...');
        Schedule::factory()
            ->longDistance()
            ->published()
            ->count($scheduleCounts['long_distance'])
            ->create();

        // Create short distance schedules
        $this->command->info('Creating short distance schedules...');
        Schedule::factory()
            ->shortDistance()
            ->published()
            ->count($scheduleCounts['short_distance'])
            ->create();

        // Create some schedules with specific combinations
        $this->command->info('Creating combination schedules...');

        // Published + delayed schedules
        Schedule::factory()
            ->published()
            ->delayed()
            ->count(20)
            ->create();

        // Completed + long distance schedules
        Schedule::factory()
            ->completed()
            ->longDistance()
            ->count(15)
            ->create();

        // Today + in progress schedules
        Schedule::factory()
            ->today()
            ->inProgress()
            ->count(10)
            ->create();

        // Tomorrow + high capacity schedules
        Schedule::factory()
            ->tomorrow()
            ->highCapacity()
            ->count(15)
            ->create();

        // Draft schedules for future planning
        Schedule::factory()
            ->draft()
            ->nextWeek()
            ->count(25)
            ->create();

        // Notification scenarios
        $this->command->info('Creating notification scenarios...');

        // All notified schedules
        Schedule::factory()
            ->allNotified()
            ->published()
            ->count(30)
            ->create();

        // Not notified schedules
        Schedule::factory()
            ->notNotified()
            ->draft()
            ->count(20)
            ->create();

        // Driver only notified schedules
        Schedule::factory()
            ->driverNotified()
            ->published()
            ->count(15)
            ->create();

        // Passenger only notified schedules
        Schedule::factory()
            ->passengerNotified()
            ->published()
            ->count(15)
            ->create();

        $totalSchedules = array_sum($scheduleCounts) + 85 + 80; // 85 combinations + 80 notification scenarios
        $this->command->info('Schedules seeded successfully!');
        $this->command->info("Total schedules created: {$totalSchedules}");
        $this->command->info('Schedule distribution:');
        $this->command->info('- Regular: '.$scheduleCounts['regular']);
        $this->command->info('- Published: '.$scheduleCounts['published']);
        $this->command->info('- Completed: '.$scheduleCounts['completed']);
        $this->command->info('- Cancelled: '.$scheduleCounts['cancelled']);
        $this->command->info('- Delayed: '.$scheduleCounts['delayed']);
        $this->command->info('- In Progress: '.$scheduleCounts['in_progress']);
        $this->command->info('- Today: '.$scheduleCounts['today']);
        $this->command->info('- Tomorrow: '.$scheduleCounts['tomorrow']);
        $this->command->info('- Next Week: '.$scheduleCounts['next_week']);
        $this->command->info('- High Capacity: '.$scheduleCounts['high_capacity']);
        $this->command->info('- Long Distance: '.$scheduleCounts['long_distance']);
        $this->command->info('- Short Distance: '.$scheduleCounts['short_distance']);
        $this->command->info('- Combinations: 85');
        $this->command->info('- Notification Scenarios: 80');
    }
}
