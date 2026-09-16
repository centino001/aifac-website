<!-- Ticket Pass Selection Modal -->
<div id="ticketTypeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-black border border-gray-700 rounded-lg max-w-2xl w-full mx-4 my-8 transform transition-all duration-300 scale-95 opacity-0" id="ticketTypeModalContent">
        <div class="flex items-center justify-between p-6 border-b border-gray-700">
            <div>
                <h3 class="text-xl font-semibold text-[#f3ead8]">Choose Your Pass</h3>
                <p class="text-sm text-gray-400 mt-1">GBSAAC 2026 — New Culture Studios, Ibadan</p>
            </div>
            <button type="button" class="text-gray-400 hover:text-white transition-colors" onclick="closeTicketTypeModal()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6 grid gap-4 sm:grid-cols-2">
            @foreach(config('summit.tickets') as $type => $ticket)
                <button type="button"
                        onclick="selectTicketPass('{{ $type }}')"
                        class="text-left border border-[#f3ead8]/40 hover:border-[#f3ead8] hover:bg-[#f3ead8]/5 rounded-lg p-5 transition duration-300 group">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h4 class="font-semibold text-[#f3ead8] text-lg leading-tight">{{ $ticket['name'] }}</h4>
                        <span class="shrink-0 text-white font-bold">₦{{ number_format($ticket['price']) }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-3">{{ $ticket['day_label'] }}</p>
                    <p class="text-xs uppercase tracking-wide text-gray-500 mb-2">Includes</p>
                    <ul class="space-y-1.5">
                        @foreach($ticket['includes'] as $item)
                            <li class="text-sm text-gray-300 flex gap-2">
                                <span class="text-[#f3ead8] mt-0.5">•</span>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-4 text-sm font-semibold text-[#f3ead8] group-hover:underline">Select this pass →</p>
                </button>
            @endforeach
        </div>
    </div>
</div>
