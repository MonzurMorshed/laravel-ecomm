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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // e.g., 'Stripe', 'PayPal'
            $table->string('provider'); // e.g., 'stripe', 'paypal'
            $table->boolean('is_active')->default(true); // Is the gateway active or not
            $table->json('credentials')->nullable(); // API keys and other configuration details
            $table->enum('environment', ['sandbox', 'production'])->default('sandbox'); // Gateway environment
            $table->timestamps(); // Created at, Updated at

            // Add additional optional columns for security purposes if needed
            // $table->string('encryption_key')->nullable(); // for secure API key storage
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
