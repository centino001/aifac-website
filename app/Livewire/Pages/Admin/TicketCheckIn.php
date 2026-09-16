<?php

namespace App\Livewire\Pages\Admin;

use App\Livewire\Concerns\AuthorizesAdminAccess;
use App\Models\Ticket;
use Livewire\Component;

class TicketCheckIn extends Component
{
    use AuthorizesAdminAccess;

    public const CODE_PREFIX = 'GBS-2026-';

    /** Full payload set by the camera scanner. */
    public string $scanInput = '';

    /** Last segment of the ticket code typed by the admin. */
    public string $codeSuffix = '';

    public ?array $lastResult = null;

    public int $paidCount = 0;

    public int $checkedInCount = 0;

    public function mount()
    {
        if ($redirect = $this->authorizeAdmin('ticket_checkin')) {
            return $redirect;
        }

        $this->refreshCounts();
    }

    public function refreshCounts(): void
    {
        $this->paidCount = Ticket::whereIn('status', [Ticket::STATUS_PAID, Ticket::STATUS_CHECKED_IN])->count();
        $this->checkedInCount = Ticket::where('status', Ticket::STATUS_CHECKED_IN)->count();
    }

    public function resetManualEntry(): void
    {
        $this->codeSuffix = '';
        $this->scanInput = '';
    }

    public function checkIn(): void
    {
        // Manual entry wins when the admin typed a suffix; otherwise use QR payload.
        if (trim($this->codeSuffix) !== '') {
            $payload = self::CODE_PREFIX.strtoupper(trim($this->codeSuffix));
        } else {
            $payload = trim($this->scanInput);
        }

        $this->scanInput = $payload;

        $this->validate([
            'scanInput' => [
                'required',
                'string',
                'min:6',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if (str_contains((string) $value, '.')) {
                        return;
                    }

                    if (trim($this->codeSuffix) === '' || strtoupper((string) $value) === strtoupper(self::CODE_PREFIX)) {
                        $fail('Enter the remaining ticket code after '.self::CODE_PREFIX);
                    }
                },
            ],
        ]);

        $ticket = Ticket::verifyPayload($this->scanInput);

        if (! $ticket) {
            $this->lastResult = [
                'success' => false,
                'message' => 'Invalid or unknown ticket. Check the QR payload or code.',
            ];
            // Clear QR payload so the next manual attempt uses the suffix field.
            $this->scanInput = '';
            $this->dispatch('checkin-feedback', success: false, message: $this->lastResult['message']);

            return;
        }

        $result = $ticket->checkIn();
        $this->lastResult = [
            'success' => $result['success'],
            'message' => $result['message'],
            'already_used' => $result['already_used'] ?? false,
            'attendee_name' => $ticket->attendee_name,
            'pass_name' => $ticket->passName(),
            'code' => $ticket->code,
            'day_label' => $ticket->dayLabel(),
            'status' => $ticket->fresh()->status,
        ];

        $this->refreshCounts();
        $this->resetManualEntry();
        $this->dispatch(
            'checkin-feedback',
            success: (bool) $result['success'],
            message: $result['message']
        );
    }

    public function render()
    {
        return view('livewire.pages.admin.ticket-check-in', [
            'codePrefix' => self::CODE_PREFIX,
        ])->layout('layouts.admin', ['title' => 'Ticket Check-In']);
    }
}
