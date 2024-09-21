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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();  // Primary key, auto-incrementing
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key for users (nullable for guest checkout)
            $table->string('order_number')->unique();  // Unique order number for tracking
            $table->decimal('total_amount', 10, 2);  // Total order amount
            $table->decimal('tax_amount', 10, 2)->nullable();  // Tax amount (optional)
            $table->decimal('shipping_amount', 10, 2)->nullable();  // Shipping charges (optional)
            $table->decimal('discount_amount', 10, 2)->nullable();  // Discount amount (if applicable)
            $table->string('status')->default('pending');  // Order status: 'pending', 'processing', 'shipped', 'completed', 'cancelled'
            $table->string('payment_status')->default('unpaid');  // Payment status: 'paid', 'unpaid', 'refunded'
            $table->string('shipping_method')->nullable();  // Shipping method used (e.g., 'standard', 'express')
            $table->string('payment_method')->nullable();  // Payment method used (e.g., 'credit_card', 'paypal')
            $table->text('order_notes')->nullable();  // Optional notes from the customer
            $table->json('items');  // Store order items in JSON format (alternatively, use a separate order_items table)
            
            // Customer information
            $table->string('customer_name');  // Customer name
            $table->string('customer_email');  // Customer email address
            $table->string('customer_phone')->nullable();  // Customer phone number (optional)
            
            // Shipping address
            $table->string('shipping_address');  // Shipping address line
            $table->string('shipping_city');  // Shipping city
            $table->string('shipping_state');  // Shipping state or province
            $table->string('shipping_postcode');  // Postal/zip code
            $table->string('shipping_country');  // Country

            // Timestamps
            $table->timestamp('shipped_at')->nullable();  // Date and time when the order was shipped
            $table->timestamp('delivered_at')->nullable();  // Date and time when the order was delivered
            $table->timestamps();  // Laravel's created_at and updated_at fields

            // Foreign key constraint for the user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
