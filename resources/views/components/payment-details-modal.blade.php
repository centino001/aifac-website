<!-- Payment Details Modal -->
<div id="paymentDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-black border border-gray-700 rounded-lg max-w-md w-full mx-4 my-8 transform transition-all duration-300 scale-95 opacity-0" id="paymentDetailsModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            <div>
                <h3 class="text-lg font-semibold text-white">Payment Details</h3>
                <p class="text-sm text-gray-400 mt-1" id="donationTypeText">Donating to the Foundation</p>
            </div>
            <button type="button" class="text-gray-400 hover:text-white transition-colors" onclick="closePaymentDetailsModal()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-4">
            <form id="paymentDetailsForm" class="space-y-4">
                <!-- Full Name -->
                <div>
                    <label for="donorName" class="block text-sm font-medium text-white mb-2">Full Name *</label>
                    <input type="text" id="donorName" name="name" required 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors"
                           placeholder="Enter your full name">
                </div>

                <!-- Email -->
                <div>
                    <label for="donorEmail" class="block text-sm font-medium text-white mb-2">Email Address *</label>
                    <input type="email" id="donorEmail" name="email" required 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors"
                           placeholder="Enter your email address">
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="donorPhone" class="block text-sm font-medium text-white mb-2">Phone Number *</label>
                    <input type="tel" id="donorPhone" name="phone" required 
                           class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors"
                           placeholder="Enter your phone number">
                </div>

                <!-- Amount -->
                <div>
                    <label for="donationAmount" class="block text-sm font-medium text-white mb-2">Donation Amount (₦) *</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">₦</span>
                        <input type="number" id="donationAmount" name="amount" required min="100" step="100"
                               class="w-full pl-8 pr-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors"
                               placeholder="0.00">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Minimum donation amount is ₦100</p>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="px-4 py-3 border-t border-gray-700">
            <div class="flex flex-col sm:flex-row gap-2">
                <button type="button" onclick="closePaymentDetailsModal()" 
                        class="flex-1 px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium text-sm">
                    Cancel
                </button>
                <button type="button" onclick="proceedToPayment()" 
                        class="flex-1 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors font-medium text-sm">
                    Proceed to Payment
                </button>
            </div>
            <p class="text-xs text-gray-400 text-center mt-2">Your information is secure and will only be used for donation processing</p>
        </div>
    </div>
</div> 