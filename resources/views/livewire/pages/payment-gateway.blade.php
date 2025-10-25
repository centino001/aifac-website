<div class="min-h-screen bg-black py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">Payment Gateway</h1>
            <p class="text-gray-300">Complete your donation to support our mission</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Payment Summary -->
            <div class="bg-black border border-gray-700 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-white mb-6">Payment Summary</h2>
                
                <div class="space-y-4">
                    <!-- Donation Type -->
                    <div class="flex justify-between items-center py-3 border-b border-gray-700">
                        <span class="text-gray-300">Donation Type:</span>
                        <span class="text-white font-medium">
                            @if($type === 'project')
                                Project Donation
                            @else
                                Foundation Donation
                            @endif
                        </span>
                    </div>

                    <!-- Donor Information -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Name:</span>
                            <span class="text-white">{{ $name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Email:</span>
                            <span class="text-white">{{ $email }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300">Phone:</span>
                            <span class="text-white">{{ $phone }}</span>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="flex justify-between items-center py-4 border-t border-gray-700">
                        <span class="text-lg font-medium text-white">Total Amount:</span>
                        <span class="text-2xl font-bold text-orange-500">₦{{ number_format($amount) }}</span>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 p-4 bg-gray-800 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span class="text-sm text-gray-300">Your payment is secured with 256-bit SSL encryption</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-black border border-gray-700 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-white mb-6">Choose Payment Method</h2>
                
                <div class="space-y-4">
                    <!-- Card Payment -->
                    <div class="payment-method-card border border-gray-600 rounded-lg p-4 hover:border-orange-500 cursor-pointer transition-colors" onclick="selectPaymentMethod('card')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-blue-600 p-3 rounded-full mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-white">Debit/Credit Card</h3>
                                    <p class="text-sm text-gray-400">Pay with Visa, Mastercard, or Verve</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" class="h-6">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" class="h-6">
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="payment-method-card border border-gray-600 rounded-lg p-4 hover:border-orange-500 cursor-pointer transition-colors" onclick="selectPaymentMethod('transfer')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-green-600 p-3 rounded-full mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-white">Bank Transfer</h3>
                                    <p class="text-sm text-gray-400">Direct transfer from your bank account</p>
                                </div>
                            </div>
                            <span class="text-sm text-green-400 font-medium">Instant</span>
                        </div>
                    </div>

                    <!-- USSD -->
                    <div class="payment-method-card border border-gray-600 rounded-lg p-4 hover:border-orange-500 cursor-pointer transition-colors" onclick="selectPaymentMethod('ussd')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-purple-600 p-3 rounded-full mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-white">USSD</h3>
                                    <p class="text-sm text-gray-400">Pay using your mobile phone</p>
                                </div>
                            </div>
                            <span class="text-sm text-purple-400 font-medium">No Internet Required</span>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="payment-method-card border border-gray-600 rounded-lg p-4 hover:border-orange-500 cursor-pointer transition-colors" onclick="selectPaymentMethod('qr')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-orange-600 p-3 rounded-full mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-white">QR Code</h3>
                                    <p class="text-sm text-gray-400">Scan and pay with your mobile app</p>
                                </div>
                            </div>
                            <span class="text-sm text-orange-400 font-medium">Quick</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <button onclick="goBack()" class="flex-1 px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium">
                        Go Back
                    </button>
                    <button id="proceedBtn" onclick="proceedWithPayment()" disabled class="flex-1 px-6 py-3 bg-orange-600 hover:bg-orange-700 disabled:bg-gray-600 disabled:cursor-not-allowed text-white rounded-lg transition-colors font-medium">
                        Proceed to Pay ₦{{ number_format($amount) }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedPaymentMethod = null;

function selectPaymentMethod(method) {
    selectedPaymentMethod = method;
    
    // Remove previous selections
    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.classList.remove('border-orange-500', 'bg-gray-800');
        card.classList.add('border-gray-600');
    });
    
    // Highlight selected method
    event.currentTarget.classList.remove('border-gray-600');
    event.currentTarget.classList.add('border-orange-500', 'bg-gray-800');
    
    // Enable proceed button
    document.getElementById('proceedBtn').disabled = false;
}

async function proceedWithPayment() {
    if (!selectedPaymentMethod) {
        alert('Please select a payment method');
        return;
    }
    
    const proceedBtn = document.getElementById('proceedBtn');
    const originalContent = proceedBtn.innerHTML;
    
    // Show loading state
    proceedBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Initializing Payment...';
    proceedBtn.disabled = true;
    
    try {
        const paymentData = {
            name: '{{ $name }}',
            email: '{{ $email }}',
            phone: '{{ $phone }}',
            amount: '{{ $amount }}',
            type: '{{ $type }}',
            project_id: '{{ $projectId }}',
            message: null,
            _token: '{{ csrf_token() }}'
        };
        
        // Initialize payment with Flutterwave
        const response = await fetch('/payment/initialize', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(paymentData)
        });
        
        const result = await response.json();
        
        if (result.success && result.authorization_url) {
            // Redirect to Flutterwave payment page
            window.location.href = result.authorization_url;
        } else {
            alert(result.message || 'Failed to initialize payment. Please try again.');
            proceedBtn.innerHTML = originalContent;
            proceedBtn.disabled = false;
        }
    } catch (error) {
        console.error('Payment initialization error:', error);
        alert('An error occurred while processing your payment. Please try again.');
        proceedBtn.innerHTML = originalContent;
        proceedBtn.disabled = false;
    }
}

function goBack() {
    window.history.back();
}
</script>
