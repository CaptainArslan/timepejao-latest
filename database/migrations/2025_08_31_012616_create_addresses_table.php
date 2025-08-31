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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            // Polymorphic relation
            $table->morphs('addressable'); // addressable_id & addressable_type
            // Address fields
            $table->string('label')->comment('e.g. Home, Office, Billing')->nullable(); // e.g. Home, Office, Billing
            $table->string('name')->comment('Person or company name')->nullable(); // Person or company name
            $table->string('phone')->comment('Phone number')->nullable();

            $table->string('address_line1')->comment('Address line 1');
            $table->string('address_line2')->comment('Address line 2')->nullable();
            $table->string('city')->comment('City');
            $table->string('state')->comment('State')->nullable();
            $table->string('postal_code')->comment('Postal code')->nullable();
            $table->string('country', 2)->comment('ISO country code (e.g. US, PK)'); // ISO country code (e.g. US, PK)

            $table->decimal('latitude', 10, 7)->comment('Latitude')->nullable();
            $table->decimal('longitude', 10, 7)->comment('Longitude')->nullable();

            $table->boolean('is_default')->comment('Mark default address')->default(false); // mark default address
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
