<?php

namespace App\Livewire\Pages\Admin;

use App\Livewire\Concerns\AuthorizesAdminAccess;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TicketRecords extends Component
{
    use AuthorizesAdminAccess;
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public string $typeFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => '', 'as' => 'status'],
        'typeFilter' => ['except' => '', 'as' => 'type'],
    ];

    public function mount()
    {
        if ($redirect = $this->authorizeAdmin('ticket_records')) {
            return $redirect;
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingTypeFilter(): void
    {
        $this->resetPage();
    }

    public function filterCheckedInOnly(): void
    {
        $this->statusFilter = Ticket::STATUS_CHECKED_IN;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'typeFilter']);
        $this->resetPage();
    }

    public function exportCsv(): StreamedResponse
    {
        $filename = 'gbs2026-tickets-'.now()->format('Y-m-d-His').'.csv';
        $tickets = $this->filteredQuery()->with('payment')->latest('id')->get();

        return response()->streamDownload(function () use ($tickets) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Name',
                'Email',
                'Phone',
                'Pass Type',
                'Ticket Code',
                'Status',
                'Amount',
                'Paid At',
                'Checked In At',
                'Payment Reference',
            ]);

            foreach ($tickets as $ticket) {
                fputcsv($handle, [
                    $ticket->attendee_name,
                    $ticket->attendee_email,
                    $ticket->attendee_phone,
                    $ticket->passName(),
                    $ticket->code,
                    $ticket->status,
                    $ticket->payment?->amount ?? $ticket->passPrice(),
                    optional($ticket->payment?->paid_at)->format('Y-m-d H:i:s'),
                    optional($ticket->checked_in_at)->format('Y-m-d H:i:s'),
                    $ticket->payment?->reference_number
                        ?? $ticket->payment?->payment_reference
                        ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function filteredQuery(): Builder
    {
        return Ticket::query()
            ->when($this->search !== '', function (Builder $query) {
                $term = '%'.trim($this->search).'%';
                $query->where(function (Builder $inner) use ($term) {
                    $inner->where('attendee_name', 'like', $term)
                        ->orWhere('attendee_email', 'like', $term)
                        ->orWhere('code', 'like', $term);
                });
            })
            ->when($this->statusFilter !== '', fn (Builder $query) => $query->where('status', $this->statusFilter))
            ->when($this->typeFilter !== '', fn (Builder $query) => $query->where('ticket_type', $this->typeFilter));
    }

    protected function summary(): array
    {
        $sold = Ticket::whereIn('status', [Ticket::STATUS_PAID, Ticket::STATUS_CHECKED_IN])->count();
        $checkedIn = Ticket::where('status', Ticket::STATUS_CHECKED_IN)->count();
        $pending = Ticket::where('status', Ticket::STATUS_PENDING)->count();
        $revenue = (float) Payment::query()
            ->where('donation_type', 'ticket')
            ->where('status', 'successful')
            ->sum('amount');
        $fullSold = Ticket::where('ticket_type', Ticket::TYPE_FULL)
            ->whereIn('status', [Ticket::STATUS_PAID, Ticket::STATUS_CHECKED_IN])
            ->count();
        $day2Sold = Ticket::where('ticket_type', Ticket::TYPE_DAY_2)
            ->whereIn('status', [Ticket::STATUS_PAID, Ticket::STATUS_CHECKED_IN])
            ->count();

        return compact('sold', 'checkedIn', 'pending', 'revenue', 'fullSold', 'day2Sold');
    }

    public function render()
    {
        $summary = $this->summary();

        return view('livewire.pages.admin.ticket-records', [
            'tickets' => $this->filteredQuery()
                ->with('payment')
                ->latest('id')
                ->paginate(20),
            'sold' => $summary['sold'],
            'checkedIn' => $summary['checkedIn'],
            'pending' => $summary['pending'],
            'revenue' => $summary['revenue'],
            'fullSold' => $summary['fullSold'],
            'day2Sold' => $summary['day2Sold'],
        ])->layout('layouts.admin', ['title' => 'Ticket Records']);
    }
}
