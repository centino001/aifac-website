<?php

namespace App\Services;

use App\Mail\TicketConfirmation;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class TicketMailService
{
    /**
     * Send thank-you + e-ticket email.
     * When RESEND_KEY is set, uses Resend HTTP (reliable). Otherwise uses the
     * configured mailer. Never treats the "log" mailer as a real delivery.
     */
    public function sendConfirmation(Ticket $ticket): bool
    {
        $ticket = $ticket->fresh() ?? $ticket;
        $apiKey = config('services.resend.key') ?: env('RESEND_KEY');

        if ($apiKey) {
            if ($this->sendViaResendHttp($ticket, $apiKey)) {
                return true;
            }
        }

        if (config('mail.default') === 'log') {
            Log::error('Ticket email not sent: MAIL_MAILER=log and Resend failed/missing. Set RESEND_KEY and MAIL_FROM_ADDRESS to a verified domain.', [
                'ticket_id' => $ticket->id,
                'to' => $ticket->attendee_email,
            ]);

            return false;
        }

        try {
            Mail::to($ticket->attendee_email)->send(new TicketConfirmation($ticket));

            Log::info('Ticket confirmation mailed via Laravel mailer', [
                'ticket_id' => $ticket->id,
                'mailer' => config('mail.default'),
                'to' => $ticket->attendee_email,
            ]);

            return true;
        } catch (Throwable $e) {
            Log::error('Laravel mailer failed for ticket email', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
            ]);
        }

        return false;
    }

    protected function sendViaResendHttp(Ticket $ticket, string $apiKey): bool
    {
        try {
            $mailable = new TicketConfirmation($ticket);
            $html = $mailable->render();
            $attachments = [];

            if ($mailable->eticketPath && is_readable($mailable->eticketPath)) {
                $attachments[] = [
                    'filename' => 'GBSAAC-2026-'.$ticket->code.'.png',
                    'content' => base64_encode((string) file_get_contents($mailable->eticketPath)),
                ];
            }

            $fromAddress = config('mail.from.address');
            $fromName = config('mail.from.name') ?: 'GBSAAC 2026';

            $response = Http::withOptions(['verify' => false])
                ->withToken($apiKey)
                ->acceptJson()
                ->post('https://api.resend.com/emails', [
                    'from' => sprintf('%s <%s>', $fromName, $fromAddress),
                    'to' => [$ticket->attendee_email],
                    'subject' => 'Thank you — your GBSAAC 2026 e-ticket ('.$ticket->passName().')',
                    'html' => $html,
                    'attachments' => $attachments,
                ]);

            if ($response->successful()) {
                Log::info('Ticket confirmation sent via Resend', [
                    'ticket_id' => $ticket->id,
                    'resend_id' => $response->json('id'),
                    'to' => $ticket->attendee_email,
                ]);

                return true;
            }

            Log::error('Resend API rejected ticket email', [
                'ticket_id' => $ticket->id,
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
            ]);
        } catch (Throwable $e) {
            Log::error('Resend API exception', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
            ]);
        }

        return false;
    }

    public function markReceiptSent(Payment $payment, bool $sent): void
    {
        if (! $sent) {
            return;
        }

        $payment->update([
            'receipt_sent' => true,
            'receipt_sent_at' => now(),
        ]);
    }
}
