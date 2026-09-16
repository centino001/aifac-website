<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_CHECKED_IN = 'checked_in';

    public const TYPE_FULL = 'full';
    public const TYPE_DAY_2 = 'day_2';

    protected $fillable = [
        'payment_id',
        'code',
        'ticket_type',
        'attendee_name',
        'attendee_email',
        'attendee_phone',
        'status',
        'checked_in_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public static function generateCode(): string
    {
        do {
            $code = 'GBS-2026-' . strtoupper(Str::random(6));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function passName(): string
    {
        return config("summit.tickets.{$this->ticket_type}.name", 'Summit Ticket');
    }

    public function passPrice(): int
    {
        return (int) config("summit.tickets.{$this->ticket_type}.price", 0);
    }

    public function dayLabel(): string
    {
        return config("summit.tickets.{$this->ticket_type}.day_label", '');
    }

    /**
     * Signed payload embedded in the QR code (code + HMAC).
     */
    public function qrPayload(): string
    {
        return $this->code . '.' . $this->signature();
    }

    public function signature(): string
    {
        return substr(hash_hmac('sha256', $this->code, (string) config('app.key')), 0, 16);
    }

    public static function verifyPayload(string $payload): ?self
    {
        $payload = trim($payload);

        if (! str_contains($payload, '.')) {
            // Allow scanning bare ticket codes from printed lists.
            $ticket = self::where('code', strtoupper($payload))->first();

            return $ticket;
        }

        [$code, $signature] = explode('.', $payload, 2);
        $ticket = self::where('code', strtoupper($code))->first();

        if (! $ticket) {
            return null;
        }

        if (! hash_equals($ticket->signature(), $signature)) {
            return null;
        }

        return $ticket;
    }

    public function markPaid(): void
    {
        if ($this->status === self::STATUS_CHECKED_IN) {
            return;
        }

        $this->update(['status' => self::STATUS_PAID]);
    }

    public function checkIn(): array
    {
        if ($this->status === self::STATUS_PENDING) {
            return [
                'success' => false,
                'message' => 'This ticket has not been paid for yet.',
                'ticket' => $this,
            ];
        }

        if ($this->status === self::STATUS_CHECKED_IN) {
            return [
                'success' => false,
                'message' => 'Already checked in at ' . optional($this->checked_in_at)->format('M j, Y g:i A') . '.',
                'ticket' => $this,
                'already_used' => true,
            ];
        }

        $this->update([
            'status' => self::STATUS_CHECKED_IN,
            'checked_in_at' => now(),
        ]);

        return [
            'success' => true,
            'message' => 'Checked in successfully.',
            'ticket' => $this->fresh(),
        ];
    }

    public function qrImageUrl(int $size = 240): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?' . http_build_query([
            'size' => $size . 'x' . $size,
            'data' => $this->qrPayload(),
        ]);
    }
}
