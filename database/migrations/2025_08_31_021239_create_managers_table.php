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
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade')->comment('Associated organization');
            $table->string('full_name')->comment('Manager full name');
            $table->string('email')->unique()->comment('Manager email address');
            $table->string('password')->nullable()->comment('Manager password');
            $table->string('phone')->nullable()->comment('Manager phone number');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->comment('Manager gender');
            $table->string('image_url')->nullable()->comment('Manager image URL');
            $table->boolean('is_active')->default(true)->comment('Manager status');
            $table->timestamps();
            $table->index('organization_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
