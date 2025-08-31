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
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Vehicle type name (e.g. Bus, Car, Van)');
            $table->string('code')->unique()->comment('Unique vehicle type code');
            $table->text('description')->nullable()->comment('Vehicle type description');
            
            // Vehicle features
            $table->boolean('has_ac')->default(false)->comment('Air conditioning available');
            $table->boolean('has_wifi')->default(false)->comment('WiFi available');
            $table->boolean('has_tv')->default(false)->comment('TV/Entertainment available');
            $table->boolean('has_charging')->default(false)->comment('Charging ports available');
            $table->boolean('has_wheelchair_access')->default(false)->comment('Wheelchair accessible');
            
            // Capacity and specifications
            $table->unsignedInteger('seating_capacity')->comment('Number of seats');
            $table->unsignedInteger('standing_capacity')->default(0)->comment('Number of standing passengers');
            $table->unsignedInteger('max_capacity')->comment('Total maximum capacity');
            
            // Status
            $table->boolean('is_active')->default(true)->comment('Vehicle type status');
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['name', 'code']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_types');
    }
};
