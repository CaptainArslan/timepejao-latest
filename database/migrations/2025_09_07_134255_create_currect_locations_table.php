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
        Schema::create('currect_locations', function (Blueprint $table) {
            $table->id();
            // Polymorphic relation
            $table->morphs('locationable'); // locationable_id & locationable_type

            // Location data
            $table->decimal('latitude', 10, 7)->comment('Current latitude');
            $table->decimal('longitude', 10, 7)->comment('Current longitude');
            $table->string('address')->nullable()->comment('Current address');
            $table->string('city')->nullable()->comment('Current city');
            $table->string('state')->nullable()->comment('Current state/province');
            $table->string('country', 2)->nullable()->comment('Current country code (ISO)');
            $table->string('postal_code')->nullable()->comment('Current postal/zip code');
            $table->timestamp('location_updated_at')->nullable()->comment('Last location update timestamp');
            $table->json('metadata')->nullable()->comment('Additional location metadata');

            // Indexes
            $table->index(['locationable_id', 'locationable_type']);
            $table->index(['latitude', 'longitude']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currect_locations');
    }
};
