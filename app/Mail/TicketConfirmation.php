<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Services\EticketImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Throwable;

class TicketConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $eticketPath = null;

    public function __construct(public Ticket $ticket)
    {
        try {
            $this->eticketPath = app(EticketImageService::class)->generate($ticket);
        } catch (Throwable $e) {
            report($e);
            $this->eticketPath = null;
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you — your GBSAAC 2026 e-ticket ('.$this->ticket->passName().')',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ticket-confirmation',
            with: [
                'ticket' => $this->ticket,
                'qrUrl' => $this->ticket->qrImageUrl(280),
                'stubColor' => $this->ticket->ticket_type === Ticket::TYPE_DAY_2 ? '#f5c518' : '#e85d04',
            ],
        );
    }

    public function attachments(): array
    {
        if (! $this->eticketPath || ! is_readable($this->eticketPath)) {
            return [];
        }

        return [
            Attachment::fromPath($this->eticketPath)
                ->as('GBSAAC-2026-'.$this->ticket->code.'.png')
                ->withMime('image/png'),
        ];
    }
}
