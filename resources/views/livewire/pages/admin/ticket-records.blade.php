<div class="min-h-screen bg-black flex" x-data="{ sidebarOpen: false }">
    <x-admin.sidebar active="ticket_records" />

<div class="flex-1 flex flex-col min-w-0">
        <header class="bg-black shadow-lg border-b border-orange-600 px-4 lg:px-6 py-3 lg:py-4">
            <div class="flex justify-between items-center gap-3">
                <div class="flex items-center min-w-0">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-400 hover:text-white mr-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="min-w-0">
                        <h2 class="text-lg lg:text-xl font-bold text-white">GBSAAC 2026 Ticket Records</h2>
                        <p class="text-xs text-gray-400">Purchases, attendance, and exports</p>
                    </div>
                </div>
                <button type="button"
                        wire:click="exportCsv"
                        class="shrink-0 bg-orange-600 hover:bg-orange-700 text-white px-3 lg:px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    Export CSV
                </button>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-6 space-y-6 overflow-y-auto">
            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3 lg:gap-4">
                <div class="bg-gray-950 border border-orange-600/40 rounded-lg p-4">
                    <p class="text-xs text-gray-400">Sold</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $sold }}</p>
                </div>
                <div class="bg-gray-950 border border-orange-600/40 rounded-lg p-4">
                    <p class="text-xs text-gray-400">Checked in</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $checkedIn }}</p>
                </div>
                <div class="bg-gray-950 border border-orange-600/40 rounded-lg p-4">
                    <p class="text-xs text-gray-400">Pending payment</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $pending }}</p>
                </div>
                <div class="bg-gray-950 border border-orange-600/40 rounded-lg p-4">
                    <p class="text-xs text-gray-400">Ticket revenue</p>
                    <p class="text-xl lg:text-2xl font-bold text-white mt-1">₦{{ number_format($revenue, 0) }}</p>
                </div>
                <div class="bg-gray-950 border border-orange-600/40 rounded-lg p-4">
                    <p class="text-xs text-gray-400">Full Summit Pass</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $fullSold }}</p>
                </div>
                <div class="bg-gray-950 border border-orange-600/40 rounded-lg p-4">
                    <p class="text-xs text-gray-400">Day Pass</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $day2Sold }}</p>
                </div>
            </div>

            <div class="bg-gray-950 border border-orange-600/40 rounded-lg p-4 space-y-3">
                <div class="flex flex-col lg:flex-row gap-3 lg:items-end">
                    <div class="flex-1">
                        <label for="ticketSearch" class="block text-sm text-gray-300 mb-1">Search</label>
                        <input id="ticketSearch"
                               type="search"
                               wire:model.live.debounce.300ms="search"
                               placeholder="Name, email, or ticket code"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div class="w-full lg:w-48">
                        <label for="statusFilter" class="block text-sm text-gray-300 mb-1">Status</label>
                        <select id="statusFilter"
                                wire:model.live="statusFilter"
                                class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">All statuses</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="checked_in">Checked in</option>
                        </select>
                    </div>
                    <div class="w-full lg:w-48">
                        <label for="typeFilter" class="block text-sm text-gray-300 mb-1">Pass type</label>
                        <select id="typeFilter"
                                wire:model.live="typeFilter"
                                class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">All passes</option>
                            <option value="full">Full Summit Pass</option>
                            <option value="day_2">Summit Day Pass</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="button"
                                wire:click="filterCheckedInOnly"
                                class="px-3 py-2 border border-orange-600 text-orange-400 hover:bg-orange-600/20 rounded-lg text-sm whitespace-nowrap">
                            Checked in only
                        </button>
                        <button type="button"
                                wire:click="clearFilters"
                                class="px-3 py-2 border border-gray-600 text-gray-300 hover:bg-gray-800 rounded-lg text-sm">
                            Clear
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-gray-950 border border-orange-600/40 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-black border-b border-orange-600/40 text-left text-gray-400">
                            <tr>
                                <th class="px-4 py-3 font-medium">Name</th>
                                <th class="px-4 py-3 font-medium">Email</th>
                                <th class="px-4 py-3 font-medium">Phone</th>
                                <th class="px-4 py-3 font-medium">Pass</th>
                                <th class="px-4 py-3 font-medium">Status</th>
                                <th class="px-4 py-3 font-medium">Amount</th>
                                <th class="px-4 py-3 font-medium">Checked in</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse($tickets as $ticket)
                                <tr class="text-gray-200 hover:bg-gray-900/60">
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $ticket->attendee_name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $ticket->attendee_email }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $ticket->attendee_phone }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $ticket->passName() }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $statusClass = match ($ticket->status) {
                                                'checked_in' => 'text-green-400',
                                                'paid' => 'text-orange-300',
                                                default => 'text-gray-400',
                                            };
                                        @endphp
                                        <span class="{{ $statusClass }}">{{ str_replace('_', ' ', $ticket->status) }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        ₦{{ number_format((float) ($ticket->payment?->amount ?? $ticket->passPrice()), 0) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-400">
                                        {{ optional($ticket->checked_in_at)->format('M j, Y g:i A') ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-gray-400">
                                        No tickets match these filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tickets->hasPages())
                    <div class="px-4 py-3 border-t border-orange-600/40">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
