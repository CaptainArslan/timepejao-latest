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
        Schema::create('organization_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('e.g. Primary, Middle School'); // e.g. Primary, Middle School
            $table->string('description')->comment('e.g. Play to 5th')->nullable(); // e.g. Play to 5th
            $table->unsignedInteger('start_class')->comment('e.g. 1')->nullable(); // e.g. 1
            $table->unsignedInteger('end_class')->comment('e.g. 5')->nullable();   // e.g. 5
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_types');
    }
};
