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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation (e.g., belongs to User, Company, etc.)
            $table->morphs('payment_methodable', indexName: 'pm_methodable_idx');
            // Core fields
            $table->string('type')->comment('e.g. card, bank_transfer, paypal, etc.');
            $table->string('provider')->comment('e.g. stripe, paypal, finix, etc.');
            $table->string('provider_payment_method_id')->nullable()->comment('External ID from payment gateway');
            $table->string('token')->nullable()->comment('Token/nonce from provider');

            // Card/bank details (safe fields only, never full numbers)
            $table->string('brand')->nullable()->comment('Card brand: visa, mastercard, amex, etc.');
            $table->string('last_four', 4)->nullable()->comment('Last 4 digits of card or account number');
            $table->unsignedTinyInteger('exp_month')->nullable();
            $table->unsignedSmallInteger('exp_year')->nullable();

            // Bank transfer specific
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_holder_type')->nullable()->comment('individual or company');

            // Flags
            $table->boolean('is_default')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->string('status')->default('active')->comment('active, inactive, expired, failed');

            // Extra data
            $table->json('meta')->nullable()->comment('Store gateway-specific response or metadata');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
