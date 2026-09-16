<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Ticket;
use App\Services\TicketMailService;
use Illuminate\Console\Command;

class SendTestTicketEmail extends Command
{
    protected $signature = 'tickets:send-test {email} {--type=full : full or day_2}';

    protected $description = 'Generate a sample paid ticket and email the e-ticket via Resend';

    public function handle(TicketMailService $mailer): int
    {
        $type = $this->option('type') === 'day_2' ? 'day_2' : 'full';
        $email = $this->argument('email');

        $payment = Payment::create([
            'reference_number' => Payment::generateReferenceNumber(),
            'donor_name' => 'Test Attendee',
            'donor_email' => $email,
            'donor_phone' => '08000000000',
            'amount' => config("summit.tickets.{$type}.price"),
            'donation_type' => 'ticket',
            'status' => 'successful',
            'paid_at' => now(),
            'metadata' => ['source' => 'tickets:send-test', 'ticket_type' => $type],
        ]);

        $ticket = Ticket::create([
            'payment_id' => $payment->id,
            'code' => Ticket::generateCode(),
            'ticket_type' => $type,
            'attendee_name' => 'Test Attendee',
            'attendee_email' => $email,
            'attendee_phone' => '08000000000',
            'status' => Ticket::STATUS_PAID,
        ]);

        $this->info("Created ticket {$ticket->code} ({$ticket->passName()})");

        if ($mailer->sendConfirmation($ticket)) {
            $payment->update(['receipt_sent' => true, 'receipt_sent_at' => now()]);
            $this->info('Email sent to '.$email);

            return self::SUCCESS;
        }

        $this->error('Email failed. Set RESEND_KEY and a verified MAIL_FROM_ADDRESS, then check storage/logs/laravel.log');

        return self::FAILURE;
    }
}
