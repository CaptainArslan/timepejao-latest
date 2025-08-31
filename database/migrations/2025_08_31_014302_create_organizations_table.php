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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Organization name');
            $table->string('alias')->nullable()->comment('Organization alias');
            $table->string('branch_code')->unique()->comment('Unique branch identifier');
            $table->string('code')->unique()->comment('Organization code');
            $table->text('description')->nullable()->comment('Organization description');
            $table->string('tagline')->nullable()->comment('Organization tagline');

            // Contact information
            $table->string('email')->nullable()->comment('Primary email address');
            $table->string('phone')->nullable()->comment('Primary phone number');
            $table->string('website')->nullable()->comment('Organization website');

            // Organization type relationship
            $table->foreignId('organization_type_id')->constrained()->onDelete('cascade');

            // Status and settings
            $table->boolean('is_active')->default(true)->comment('Organization status');

            // Logo and branding
            $table->string('logo_url')->nullable()->comment('Path to organization logo');

            $table->timestamps();

            // Indexes for better performance
            $table->index(['name', 'branch_code', 'code']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
