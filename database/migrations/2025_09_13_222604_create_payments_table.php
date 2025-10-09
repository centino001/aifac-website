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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Our internal reference system
            $table->string('reference_number')->unique(); // Our generated reference (e.g., AIYAK-2024-001234)
            
            // Paystack integration fields
            $table->string('paystack_reference')->nullable(); // Paystack's reference
            $table->string('paystack_access_code')->nullable(); // Paystack access code
            $table->string('paystack_transaction_id')->nullable(); // Paystack transaction ID
            
            // Donor information
            $table->string('donor_name');
            $table->string('donor_email');
            $table->string('donor_phone');
            
            // Payment details
            $table->decimal('amount', 12, 2); // Amount in Naira
            $table->string('currency', 3)->default('NGN');
            $table->enum('donation_type', ['foundation', 'project'])->default('foundation');
            $table->string('project_id')->nullable(); // For project-specific donations
            $table->text('message')->nullable(); // Optional donor message
            
            // Payment status and method
            $table->enum('status', ['pending', 'processing', 'successful', 'failed', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable(); // card, bank_transfer, ussd, qr, etc.
            $table->string('payment_channel')->nullable(); // Paystack channel used
            
            // Transaction details
            $table->timestamp('paid_at')->nullable();
            $table->json('paystack_response')->nullable(); // Store full Paystack response
            $table->string('authorization_code')->nullable(); // For recurring payments
            $table->string('card_type')->nullable(); // visa, mastercard, etc.
            $table->string('last4')->nullable(); // Last 4 digits of card
            $table->string('bank')->nullable(); // Bank name for transfers
            
            // Receipt and communication
            $table->boolean('receipt_sent')->default(false);
            $table->timestamp('receipt_sent_at')->nullable();
            $table->string('receipt_number')->nullable(); // Receipt tracking number
            
            // Additional tracking
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable(); // Additional data
            
            // Refund information
            $table->boolean('refunded')->default(false);
            $table->decimal('refund_amount', 12, 2)->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->text('refund_reason')->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['status', 'created_at']);
            $table->index(['donor_email', 'created_at']);
            $table->index(['donation_type', 'project_id']);
            $table->index('paystack_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
