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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            // Vehicle Type Relationship
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('cascade')->comment('Vehicle type');
            $table->foreignId('organization_id')->constrained()->onDelete('cascade')->comment('Owning organization');

            // Vehicle Identification
            $table->string('registration_number')->unique()->comment('Vehicle registration number');
            $table->string('vin')->unique()->comment('Vehicle Identification Number');
            $table->string('chassis_number')->unique()->comment('Chassis number');

            // Vehicle Information
            $table->string('license_plate')->unique()->comment('License plate number');
            $table->string('make')->nullable()->comment('Vehicle make (e.g. Toyota, Honda)');
            $table->string('model')->nullable()->comment('Vehicle model (e.g. Camry, Civic)');
            $table->string('year')->nullable()->comment('Manufacturing year');
            $table->string('color')->nullable()->comment('Vehicle color');

            // Capacity and specifications
            $table->unsignedInteger('seating_capacity')->nullable()->comment('Number of seats');
            $table->unsignedInteger('standing_capacity')->default(0)->nullable()->comment('Number of standing passengers');
            $table->unsignedInteger('max_capacity')->nullable()->comment('Total maximum capacity');

            // Additional Information
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->string('image_url')->nullable()->comment('Vehicle image URL');
            $table->string('front_image')->nullable()->comment('Front view image');
            $table->string('back_image')->nullable()->comment('Back view image');
            $table->json('additional_images')->nullable()->comment('Additional vehicle images');
            $table->boolean('is_active')->default(true)->comment('Vehicle status');

            $table->timestamps();

            // Indexes for better performance
            $table->index(['registration_number', 'license_plate']);
            $table->index(['make', 'model']);
            $table->index(['vehicle_type_id', 'organization_id']);
            $table->index(['seating_capacity', 'standing_capacity']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
