<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Organization;
use App\Models\Passenger;
use App\Models\TransportRoute;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    public function definition(): array
    {
        // Schedule base: date within next 30 days
        $scheduleDate = Carbon::instance($this->faker->dateTimeBetween('now', '+30 days'))->startOfDay();

        // Generate a coherent schedule window (may be overnight with small probability)
        [$scheduledDeparture, $scheduledArrival, $overnight] = $this->makeScheduledWindow($scheduleDate);

        // Default: not delayed, no actuals yet
        $isDelayed = false;
        $delayMinutes = 0;
        $delayReason = null;
        $delayStart = null;
        $delayResolved = null;

        return [
            'organization_id' => Organization::inRandomOrder()->first()->id,
            'transport_route_id' => TransportRoute::inRandomOrder()->first()->id,
            'vehicle_id' => Vehicle::inRandomOrder()->first()->id,
            'driver_id' => Driver::inRandomOrder()->first()->id,
            'passenger_id' => Passenger::inRandomOrder()->first()->id,

            'schedule_date' => $scheduleDate->toDateString(),
            'scheduled_departure_time' => $scheduledDeparture->format('H:i'),
            'scheduled_arrival_time' => $scheduledArrival->format('H:i'),

            // Default actuals: null (set by states that need them)
            'actual_departure_time' => null,
            'actual_arrival_time' => null,

            // Statuses (refined by states)
            'schedule_status' => 'draft', // draft|published|cancelled|completed|archived
            'trip_status' => 'scheduled', // scheduled|boarding|departed|in_transit|arrived|delayed|cancelled|completed

            // Delay fields (refined by states)
            'is_delayed' => $isDelayed,
            'delay_minutes' => $delayMinutes,
            'delay_reason' => $delayReason,
            'delay_started_at' => $delayStart,
            'delay_resolved_at' => $delayResolved,

            'notes' => $this->faker->optional(0.4)->sentence(),
            'metadata' => [
                'overnight' => $overnight,
                'weather' => $this->faker->randomElement(['sunny', 'cloudy', 'rainy', 'snowy', 'foggy']),
                'traffic_level' => $this->faker->randomElement(['low', 'medium', 'high', 'severe']),
                'route_condition' => $this->faker->randomElement(['good', 'fair', 'poor']),
                'passenger_satisfaction' => $this->faker->randomFloat(1, 1, 5),
            ],
            'passenger_count' => $this->faker->numberBetween(1, 4),
            'distance_km' => $this->faker->randomFloat(2, 5, 500),
            'estimated_duration_minutes' => $this->faker->numberBetween(15, 720),
            'is_driver_notified' => $this->faker->boolean(80), // 80% chance driver is notified
            'is_passenger_notified' => $this->faker->boolean(85), // 85% chance passenger is notified
        ];
    }

    /* =========================
     |   SCHEDULE STATUS STATES
     |=========================*/

    public function draft(): self
    {
        return $this->state(fn (array $a) => [
            'schedule_status' => 'draft',
            'trip_status' => 'scheduled',
        ]);
    }

    public function published(): self
    {
        return $this->state(fn (array $a) => [
            'schedule_status' => 'published',
        ]);
    }

    public function archived(): self
    {
        return $this->state(fn (array $a) => [
            'schedule_status' => 'archived',
            // Keep last known trip_status as-is
        ]);
    }

    public function scheduleCancelled(): self
    {
        return $this->state(function (array $a) {
            return [
                'schedule_status' => 'cancelled',
                'trip_status' => 'cancelled',
                'actual_departure_time' => null,
                'actual_arrival_time' => null,
                'is_delayed' => false,
                'delay_minutes' => 0,
                'delay_reason' => null,
                'delay_started_at' => null,
                'delay_resolved_at' => null,
            ];
        });
    }

    /**
     * Indicate that the schedule is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule_status' => 'cancelled',
            'trip_status' => 'cancelled',
            'notes' => 'Schedule cancelled due to unforeseen circumstances',
        ]);
    }

    /**
     * Indicate that the trip is delayed.
     */
    public function delayed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_delayed' => true,
            'delay_minutes' => $this->faker->numberBetween(10, 60),
            'delay_reason' => $this->faker->randomElement([
                'Traffic congestion',
                'Vehicle breakdown',
                'Weather conditions',
                'Driver delay',
            ]),
            'delay_started_at' => $this->faker->dateTimeBetween('-1 hour', 'now'),
            'trip_status' => 'delayed',
        ]);
    }

    /**
     * Indicate that the trip is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'trip_status' => $this->faker->randomElement(['boarding', 'departed', 'in_transit']),
            'actual_departure_time' => $this->faker->dateTimeBetween('-2 hours', 'now'),
        ]);
    }

    /**
     * Indicate that the schedule is for today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule_date' => today(),
        ]);
    }

    /**
     * Indicate that the schedule is for tomorrow.
     */
    public function tomorrow(): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule_date' => today()->addDay(),
        ]);
    }

    /**
     * Indicate that the schedule is for next week.
     */
    public function nextWeek(): static
    {
        return $this->state(fn (array $attributes) => [
            'schedule_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
        ]);
    }

    /**
     * Indicate that the schedule has high passenger count.
     */
    public function highCapacity(): static
    {
        return $this->state(fn (array $attributes) => [
            'passenger_count' => $this->faker->numberBetween(3, 4),
        ]);
    }

    /**
     * Indicate that the schedule is a long distance trip.
     */
    public function longDistance(): static
    {
        return $this->state(fn (array $attributes) => [
            'distance_km' => $this->faker->randomFloat(2, 200, 500),
            'estimated_duration_minutes' => $this->faker->numberBetween(180, 300),
        ]);
    }

    /**
     * Indicate that the schedule is a short distance trip.
     */
    public function shortDistance(): static
    {
        return $this->state(fn (array $attributes) => [
            'distance_km' => $this->faker->randomFloat(2, 5, 50),
            'estimated_duration_minutes' => $this->faker->numberBetween(15, 60),
        ]);
    }

    public function scheduleCompleted(): self
    {
        return $this->state(fn (array $a) => [
            'schedule_status' => 'completed',
            'trip_status' => 'completed',
        ]);
    }

    /* ======================
     |   TRIP STATUS STATES
     |======================*/

    public function scheduled(): self
    {
        // Before boarding, no actuals
        return $this->state(fn (array $a) => [
            'trip_status' => 'scheduled',
            'actual_departure_time' => null,
            'actual_arrival_time' => null,
        ]);
    }

    public function boarding(): self
    {
        return $this->state(fn (array $a) => [
            'trip_status' => 'boarding',
            'actual_departure_time' => null,
            'actual_arrival_time' => null,
        ]);
    }

    public function departed(): self
    {
        return $this->state(function (array $a) {
            $dep = $this->makeDateTime($a['schedule_date'], $a['scheduled_departure_time']);
            $actualDep = (clone $dep)->addMinutes($this->faker->numberBetween(-5, 20)); // small variance

            return [
                'trip_status' => 'departed',
                'actual_departure_time' => $actualDep,
                'actual_arrival_time' => null,
            ];
        });
    }

    public function inTransit(): self
    {
        return $this->state(function (array $a) {
            $dep = $this->makeDateTime($a['schedule_date'], $a['scheduled_departure_time']);
            $actualDep = (clone $dep)->addMinutes($this->faker->numberBetween(-5, 30));

            return [
                'trip_status' => 'in_transit',
                'actual_departure_time' => $actualDep,
                'actual_arrival_time' => null,
            ];
        });
    }

    public function arrived(): self
    {
        return $this->state(function (array $a) {
            [$dep, $arr] = $this->resolveScheduleWindow($a);
            $actualDep = (clone $dep)->addMinutes($this->faker->numberBetween(-5, 30));
            $actualArr = (clone $arr)->addMinutes($this->faker->numberBetween(-10, 40));
            if ($actualArr->lessThan($actualDep)) {
                $actualArr = (clone $actualDep)->addMinutes(max(10, $this->faker->numberBetween(10, 120)));
            }

            return [
                'trip_status' => 'arrived',
                'actual_departure_time' => $actualDep,
                'actual_arrival_time' => $actualArr,
            ];
        });
    }

    public function tripCancelledPreDeparture(): self
    {
        return $this->state(fn (array $a) => [
            'trip_status' => 'cancelled',
            'schedule_status' => 'cancelled',
            'actual_departure_time' => null,
            'actual_arrival_time' => null,
            'is_delayed' => false,
            'delay_minutes' => 0,
            'delay_reason' => null,
            'delay_started_at' => null,
            'delay_resolved_at' => null,
        ]);
    }

    public function tripCancelledMidway(): self
    {
        return $this->state(function (array $a) {
            [$dep, $arr] = $this->resolveScheduleWindow($a);
            $actualDep = (clone $dep)->addMinutes($this->faker->numberBetween(0, 30));

            return [
                'trip_status' => 'cancelled',
                'schedule_status' => 'cancelled',
                'actual_departure_time' => $actualDep,
                'actual_arrival_time' => null,
                'is_delayed' => false,
                'delay_minutes' => 0,
                'delay_reason' => null,
                'delay_started_at' => null,
                'delay_resolved_at' => null,
            ];
        });
    }

    public function completed(): self
    {
        return $this->arrived()->state(fn () => [
            'trip_status' => 'completed',
            'schedule_status' => 'completed',
        ]);
    }

    /* ======================
     |   TIMING VARIANTS
     |======================*/

    public function onTime(): self
    {
        return $this->state(function (array $a) {
            [$dep, $arr] = $this->resolveScheduleWindow($a);

            return [
                'is_delayed' => false,
                'delay_minutes' => 0,
                'delay_reason' => null,
                'delay_started_at' => null,
                'delay_resolved_at' => null,
                'actual_departure_time' => (clone $dep)->addMinutes($this->faker->numberBetween(-3, 5)),
                'actual_arrival_time' => (clone $arr)->addMinutes($this->faker->numberBetween(-5, 7)),
            ];
        });
    }

    public function earlyArrival(): self
    {
        return $this->state(function (array $a) {
            [$dep, $arr] = $this->resolveScheduleWindow($a);
            $actualDep = (clone $dep)->addMinutes($this->faker->numberBetween(-3, 5));
            $actualArr = (clone $arr)->subMinutes($this->faker->numberBetween(5, 20));
            if ($actualArr->lessThan($actualDep)) {
                $actualArr = (clone $actualDep)->addMinutes(5);
            }

            return [
                'is_delayed' => false,
                'delay_minutes' => 0,
                'delay_reason' => null,
                'delay_started_at' => null,
                'delay_resolved_at' => null,
                'actual_departure_time' => $actualDep,
                'actual_arrival_time' => $actualArr,
            ];
        });
    }

    public function overnight(): self
    {
        // Force an overnight arrival scenario
        return $this->state(function (array $a) {
            $date = Carbon::parse($a['schedule_date']);
            $dep = (clone $date)->setTime($this->faker->numberBetween(20, 23), $this->faker->randomElement([0, 15, 30, 45]));
            $arr = (clone $dep)->addMinutes($this->faker->numberBetween(120, 540)); // +2h..+9h -> next day likely

            return [
                'scheduled_departure_time' => $dep->format('H:i'),
                'scheduled_arrival_time' => $arr->format('H:i'),
                'metadata' => array_replace($a['metadata'] ?? [], ['overnight' => true]),
            ];
        });
    }

    /* ======================
     |   DELAY SCENARIOS
     |======================*/

    public function delayedGeneric(): self
    {
        return $this->applyDelay($this->faker->randomElement([
            'Traffic congestion',
            'Vehicle breakdown',
            'Weather conditions',
            'Driver delay',
            'Passenger delay',
            'Route closure',
            'Mechanical issue',
            'Fuel shortage',
        ]));
    }

    public function delayedTraffic(): self
    {
        return $this->applyDelay('Traffic congestion');
    }

    public function delayedWeather(): self
    {
        return $this->applyDelay('Weather conditions');
    }

    public function delayedBreakdown(): self
    {
        return $this->applyDelay('Vehicle breakdown');
    }

    public function delayedMechanical(): self
    {
        return $this->applyDelay('Mechanical issue');
    }

    public function shortDelay(): self
    {
        return $this->applyDelay(null, $this->faker->numberBetween(5, 20));
    }

    public function longDelay(): self
    {
        return $this->applyDelay(null, $this->faker->numberBetween(60, 180));
    }

    public function delayResolved(): self
    {
        return $this->state(function (array $a) {
            $now = Carbon::now()->seconds(0);
            $start = $a['delay_started_at'] ? Carbon::parse($a['delay_started_at']) : (clone $now)->subMinutes($this->faker->numberBetween(10, 90));

            return [
                'is_delayed' => true,
                'delay_started_at' => $start,
                'delay_minutes' => max($a['delay_minutes'] ?? 0, $start->diffInMinutes($now)),
                'delay_resolved_at' => $now,
                'trip_status' => $a['trip_status'] === 'delayed' ? 'in_transit' : $a['trip_status'],
            ];
        });
    }

    public function delayOngoing(): self
    {
        return $this->state(function (array $a) {
            $start = Carbon::now()->subMinutes($this->faker->numberBetween(5, 90));

            return [
                'is_delayed' => true,
                'delay_started_at' => $start,
                'delay_minutes' => $this->faker->numberBetween(5, 120),
                'delay_resolved_at' => null,
                'trip_status' => 'delayed',
            ];
        });
    }

    /* ======================
     |   UTILITIES
     |======================*/

    private function applyDelay(?string $reason = null, ?int $minutes = null): self
    {
        return $this->state(function (array $a) use ($reason, $minutes) {
            [$dep, $arr] = $this->resolveScheduleWindow($a);
            $delayMinutes = $minutes ?? $this->faker->numberBetween(5, 120);
            $start = (clone $dep)->addMinutes($this->faker->numberBetween(-10, 30)); // around departure
            $actualDep = (clone $dep)->addMinutes($delayMinutes);
            $actualArr = (clone $arr)->addMinutes($delayMinutes);

            return [
                'is_delayed' => true,
                'delay_minutes' => $delayMinutes,
                'delay_reason' => $reason ?? 'Traffic congestion',
                'delay_started_at' => $start,
                'delay_resolved_at' => $this->faker->boolean(70) ? (clone $start)->addMinutes($delayMinutes) : null,
                'trip_status' => $this->faker->randomElement(['delayed', 'in_transit']),
                'schedule_status' => $a['schedule_status'] ?? 'published',
                'actual_departure_time' => $actualDep,
                'actual_arrival_time' => $actualArr,
            ];
        });
    }

    private function makeScheduledWindow(Carbon $scheduleDate): array
    {
        // 20% chance to be a late-night departure, encouraging overnight arrivals
        $lateNight = $this->faker->boolean(20);
        $depHour = $lateNight ? $this->faker->numberBetween(20, 23) : $this->faker->numberBetween(5, 21);
        $depMin = $this->faker->randomElement([0, 10, 15, 20, 30, 40, 45, 50]);
        $dep = (clone $scheduleDate)->setTime($depHour, $depMin);

        $duration = $this->faker->numberBetween(15, 720); // 15 min to 12 hours
        $arr = (clone $dep)->addMinutes($duration);
        $overnight = $arr->isNextDay();

        return [$dep, $arr, $overnight];
    }

    private function resolveScheduleWindow(array $a): array
    {
        $dep = $this->makeDateTime($a['schedule_date'], $a['scheduled_departure_time']);
        $arr = $this->makeDateTime($a['schedule_date'], $a['scheduled_arrival_time']);
        if ($arr->lessThanOrEqualTo($dep)) {
            // Treat as overnight arrival
            $arr->addDay();
        }

        return [$dep, $arr];
    }

    private function makeDateTime(string $date, string $time): Carbon
    {
        [$h, $m] = explode(':', $time);

        return Carbon::parse($date)->setTime((int) $h, (int) $m, 0);
    }

    /**
     * Indicate that both driver and passenger are notified.
     */
    public function allNotified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_driver_notified' => true,
            'is_passenger_notified' => true,
        ]);
    }

    /**
     * Indicate that neither driver nor passenger are notified.
     */
    public function notNotified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_driver_notified' => false,
            'is_passenger_notified' => false,
        ]);
    }

    /**
     * Indicate that only the driver is notified.
     */
    public function driverNotified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_driver_notified' => true,
            'is_passenger_notified' => false,
        ]);
    }

    /**
     * Indicate that only the passenger is notified.
     */
    public function passengerNotified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_driver_notified' => false,
            'is_passenger_notified' => true,
        ]);
    }
}
