<!-- Ticket Buyer Details Modal -->
<div id="ticketDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-black border border-gray-700 rounded-lg max-w-md w-full mx-4 my-8 transform transition-all duration-300 scale-95 opacity-0" id="ticketDetailsModalContent">
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            <div>
                <h3 class="text-lg font-semibold text-[#f3ead8]">Attendee Details</h3>
                <p class="text-sm text-gray-400 mt-1" id="ticketPassSummary">Select a pass</p>
            </div>
            <button type="button" class="text-gray-400 hover:text-white transition-colors" onclick="closeTicketDetailsModal()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-4">
            <form id="ticketDetailsForm" class="space-y-4">
                <div>
                    <label for="ticketName" class="block text-sm font-medium text-white mb-2">Full Name *</label>
                    <input type="text" id="ticketName" name="name" required
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f3ead8] focus:border-transparent transition-colors"
                           placeholder="Enter your full name">
                </div>

                <div>
                    <label for="ticketEmail" class="block text-sm font-medium text-white mb-2">Email Address *</label>
                    <input type="email" id="ticketEmail" name="email" required
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f3ead8] focus:border-transparent transition-colors"
                           placeholder="Enter your email address">
                </div>

                <div>
                    <label for="ticketPhone" class="block text-sm font-medium text-white mb-2">Phone Number *</label>
                    <input type="tel" id="ticketPhone" name="phone" required
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f3ead8] focus:border-transparent transition-colors"
                           placeholder="Enter your phone number">
                </div>

                <div class="rounded-lg border border-[#f3ead8]/30 bg-[#f3ead8]/5 px-3 py-3">
                    <p class="text-xs text-gray-400 mb-1">Amount due</p>
                    <p class="text-xl font-bold text-[#f3ead8]" id="ticketAmountDisplay">₦0</p>
                </div>
            </form>
        </div>

        <div class="px-4 py-3 border-t border-gray-700">
            <div class="flex flex-col sm:flex-row gap-2">
                <button type="button" onclick="closeTicketDetailsModal()"
                        class="flex-1 px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium text-sm">
                    Cancel
                </button>
                <button type="button" id="ticketProceedBtn" onclick="proceedToTicketPayment()"
                        class="flex-1 px-4 py-2 bg-[#f3ead8] hover:bg-white text-[#1a120c] rounded-lg transition-colors font-semibold text-sm">
                    Proceed to Payment
                </button>
            </div>
            <p class="text-xs text-gray-400 text-center mt-2">Your e-ticket with QR code will be emailed after payment.</p>
        </div>
    </div>
</div>
