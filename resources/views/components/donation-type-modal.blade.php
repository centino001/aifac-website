<!-- Donation Type Selection Modal -->
<div id="donationTypeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-black border border-gray-700 rounded-lg max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="donationTypeModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white">Choose Donation Type</h3>
            <button type="button" class="text-gray-400 hover:text-white transition-colors" onclick="closeDonationTypeModal()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <p class="text-gray-300 mb-6 text-center">How would you like to contribute to our mission?</p>
            
            <div class="space-y-4">
                <!-- Donate to Foundation Option -->
                <button onclick="selectFoundationDonation()" class="w-full bg-orange-600 hover:bg-orange-700 text-white p-4 rounded-lg transition-colors duration-300 flex items-center justify-between group">
                    <div class="flex items-center">
                        <div class="bg-orange-500 p-2 rounded-full mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-semibold">Donate to the Foundation</h4>
                            <p class="text-sm text-orange-100">Support our overall mission and programs</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-orange-200 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Donate to Project Option -->
                {{-- <button onclick="selectProjectDonation()" class="w-full bg-gray-700 hover:bg-gray-600 text-white p-4 rounded-lg transition-colors duration-300 flex items-center justify-between group">
                    <div class="flex items-center">
                        <div class="bg-gray-600 p-2 rounded-full mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-semibold">Donate to a Project</h4>
                            <p class="text-sm text-gray-300">Support a specific project or initiative</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button> --}}
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-700">
            <p class="text-xs text-gray-400 text-center">Your donation helps preserve and promote African art and culture</p>
        </div>
    </div>
</div> 