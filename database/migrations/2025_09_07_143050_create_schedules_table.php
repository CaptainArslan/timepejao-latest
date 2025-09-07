<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            // Foreign Key Relationships
            $table->foreignId('organization_id')->constrained()->onDelete('cascade')->comment('Associated organization');
            $table->foreignId('transport_route_id')->constrained()->onDelete('cascade')->comment('Associated transport route');
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade')->comment('Associated vehicle');
            $table->foreignId('driver_id')->constrained()->onDelete('cascade')->comment('Associated driver');
            $table->foreignId('passenger_id')->constrained()->onDelete('cascade')->comment('Associated passenger');

            // Schedule Information
            $table->date('schedule_date')->comment('Scheduled departure date');
            $table->time('scheduled_departure_time')->comment('Scheduled departure time');
            $table->time('scheduled_arrival_time')->nullable()->comment('Scheduled arrival time');
            $table->datetime('actual_departure_time')->nullable()->comment('Actual departure time');
            $table->datetime('actual_arrival_time')->nullable()->comment('Actual arrival time');

            // Schedule Status Management
            $table->enum('schedule_status', [
                'draft',           // Schedule is being created
                'published',       // Schedule is published and available
                'cancelled',        // Schedule is cancelled
                'completed',       // Schedule is completed
                'archived',         // Schedule is archived
            ])->default('draft')->comment('Current status of the schedule');

            // Trip Status Management
            $table->enum('trip_status', [
                'scheduled',       // Trip is scheduled
                'boarding',        // Passengers are boarding
                'departed',         // Trip has departed
                'in_transit',       // Trip is in progress
                'arrived',          // Trip has arrived at destination
                'delayed',          // Trip is delayed
                'cancelled',        // Trip is cancelled
                'completed',         // Trip is completed
            ])->default('scheduled')->comment('Current status of the trip');

            // Delay Management
            $table->boolean('is_delayed')->default(false)->comment('Whether the trip is delayed');
            $table->integer('delay_minutes')->default(0)->comment('Delay duration in minutes');
            $table->text('delay_reason')->nullable()->comment('Reason for delay');
            $table->timestamp('delay_started_at')->nullable()->comment('When the delay started');
            $table->timestamp('delay_resolved_at')->nullable()->comment('When the delay was resolved');

            // Additional Information
            $table->text('notes')->nullable()->comment('Additional notes about the schedule');
            $table->json('metadata')->nullable()->comment('Additional metadata (weather, traffic, etc.)');
            $table->integer('passenger_count')->default(1)->comment('Number of passengers for this trip');
            $table->decimal('distance_km', 8, 2)->nullable()->comment('Trip distance in kilometers');
            $table->integer('estimated_duration_minutes')->nullable()->comment('Estimated trip duration in minutes');
            $table->boolean('is_driver_notified')->default(false)->comment('Whether the driver was notified');
            $table->boolean('is_passenger_notified')->default(false)->comment('Whether the passenger was notified');

            $table->timestamps();

            // Indexes for better performance
            $table->index(['schedule_date', 'scheduled_departure_time']);
            $table->index(['schedule_status', 'trip_status']);
            $table->index(['organization_id', 'schedule_date']);
            $table->index(['driver_id', 'schedule_date']);
            $table->index(['vehicle_id', 'schedule_date']);
            $table->index(['passenger_id', 'schedule_date']);
            $table->index(['transport_route_id', 'schedule_date']);
            $table->index('is_delayed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
