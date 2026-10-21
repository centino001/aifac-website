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

    public ?string $programmePath = null;

    public function __construct(public Ticket $ticket)
    {
        try {
            $this->eticketPath = app(EticketImageService::class)->generate($ticket);
        } catch (Throwable $e) {
            report($e);
            $this->eticketPath = null;
        }

        $programme = resource_path('docs/GBSAAC-2026-programme.pdf');
        $this->programmePath = is_readable($programme) ? $programme : null;
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
                'stubColor' => $this->ticket->stubColor(),
                'hasProgramme' => (bool) $this->programmePath,
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if ($this->eticketPath && is_readable($this->eticketPath)) {
            $attachments[] = Attachment::fromPath($this->eticketPath)
                ->as('GBSAAC-2026-'.$this->ticket->code.'.png')
                ->withMime('image/png');
        }

        if ($this->programmePath && is_readable($this->programmePath)) {
            $attachments[] = Attachment::fromPath($this->programmePath)
                ->as('GBSAAC-2026-Programme.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
