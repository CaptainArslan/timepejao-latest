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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            // Organization Relationship
            $table->foreignId('organization_id')->constrained()->onDelete('cascade')->comment('Associated organization');

            // Personal Information
            $table->string('full_name')->comment('Driver full name');
            $table->string('email')->unique()->comment('Driver email address');
            $table->string('password')->nullable()->comment('Driver password');
            $table->string('phone')->nullable()->comment('Driver phone number');
            $table->enum('gender', ['male', 'female', 'other'])->comment('Driver gender');

            // Professional Information
            $table->string('driver_license_number')->unique()->comment('Driver license number');
            $table->string('license_class')->comment('License class (A, B, C, etc.)');
            $table->date('license_issue_date')->comment('License issue date');
            $table->date('license_expiry_date')->comment('License expiry date');

            // Status and Settings
            $table->boolean('is_active')->default(true)->comment('Driver status');

            // Emergency Contact
            $table->string('emergency_contact_name')->nullable()->comment('Emergency contact person name');
            $table->string('emergency_contact_phone')->nullable()->comment('Emergency contact phone');
            $table->string('emergency_contact_relationship')->nullable()->comment('Relationship with emergency contact');

            // Documents and Images
            $table->string('profile_image')->nullable()->comment('Driver profile image');
            $table->string('license_front_image')->nullable()->comment('License front image');
            $table->string('license_back_image')->nullable()->comment('License back image');
            $table->string('id_card_front_image')->nullable()->comment('ID card front image');
            $table->string('id_card_back_image')->nullable()->comment('ID card back image');
            $table->string('passport_image')->nullable()->comment('Passport image');

            // Performance and Ratings
            $table->decimal('rating', 3, 2)->default(0.00)->comment('Driver rating (0.00-5.00)');
            $table->unsignedInteger('total_trips')->default(0)->comment('Total trips completed');
            $table->unsignedInteger('total_distance')->default(0)->comment('Total distance driven (km)');
            $table->unsignedInteger('accidents_count')->default(0)->comment('Number of accidents');
            $table->unsignedInteger('violations_count')->default(0)->comment('Number of traffic violations');

            $table->timestamps();

            // Indexes for better performance
            $table->index(['full_name', 'email']);
            $table->index(['email', 'driver_license_number']);
            $table->index(['driver_license_number', 'license_class']);
            $table->index('organization_id');
            $table->index('is_active');
            $table->index('license_expiry_date');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
