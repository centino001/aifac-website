<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('tickets');

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->string('code', 32)->unique();
            $table->string('ticket_type', 16); // full | day_2
            $table->string('attendee_name');
            $table->string('attendee_email');
            $table->string('attendee_phone', 40);
            $table->string('status', 20)->default('pending'); // pending | paid | checked_in
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'ticket_type']);
            $table->index('attendee_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
