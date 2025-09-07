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
        Schema::create('transport_routes', function (Blueprint $table) {
            $table->id();

            // Organization Relationship
            $table->foreignId('organization_id')->constrained()->onDelete('cascade')->comment('Associated organization');

            // Route Information
            $table->string('name')->comment('Route name (e.g. Downtown Express, Airport Shuttle)');
            $table->string('number')->comment('Unique route code');
            $table->text('description')->nullable()->comment('Route description');
            $table->json('from_address')->comment('Starting location address from Google Maps');
            $table->json('to_address')->comment('Destination location address from Google Maps');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->string('image')->nullable()->comment('Route map or image');
            $table->json('waypoints')->nullable()->comment('Route waypoints for navigation');
            $table->boolean('is_active')->default(true)->comment('Route status');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['name', 'number']);
            $table->index(['organization_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_routes');
    }
};
