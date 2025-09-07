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
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();

            // Organization Relationship
            $table->foreignId('organization_id')->constrained()->onDelete('cascade')->comment('Associated organization');

            // Personal Information
            $table->string('full_name')->comment('Passenger full name');
            $table->string('email')->unique()->comment('Passenger email address');
            $table->string('password')->nullable()->comment('Passenger password');
            $table->string('phone')->nullable()->comment('Passenger phone number');
            $table->enum('gender', ['male', 'female', 'other'])->comment('Passenger gender');
            $table->date('date_of_birth')->nullable()->comment('Passenger date of birth');
            $table->string('national_id')->nullable()->unique()->comment('National ID number');
            $table->string('passport_number')->nullable()->unique()->comment('Passport number');

            // Status and Settings
            $table->boolean('is_active')->default(true)->comment('Passenger status');
            $table->boolean('is_verified')->default(false)->comment('Passenger verification status');

            // Emergency Contact
            $table->string('emergency_contact_name')->nullable()->comment('Emergency contact person name');
            $table->string('emergency_contact_phone')->nullable()->comment('Emergency contact phone');
            $table->string('emergency_contact_relationship')->nullable()->comment('Relationship with emergency contact');

            // Documents and Images
            $table->string('profile_image')->nullable()->comment('Passenger profile image');
            $table->string('national_id_front_image')->nullable()->comment('National ID front image');
            $table->string('national_id_back_image')->nullable()->comment('National ID back image');
            $table->string('passport_image')->nullable()->comment('Passport image');

            // Preferences
            $table->json('preferences')->nullable()->comment('Passenger preferences (language, notifications, etc.)');
            $table->string('preferred_language')->default('en')->comment('Preferred language');
            $table->boolean('sms_notifications')->default(true)->comment('SMS notifications enabled');
            $table->boolean('email_notifications')->default(true)->comment('Email notifications enabled');
            $table->boolean('push_notifications')->default(true)->comment('Push notifications enabled');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['full_name', 'email']);
            $table->index(['email', 'phone']);
            $table->index(['national_id', 'passport_number']);
            $table->index('organization_id');
            $table->index('is_active');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
