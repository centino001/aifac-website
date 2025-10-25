<div class="min-h-screen bg-black flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <!-- Success Animation Container -->
        <div class="text-center mb-8">
            <div class="mx-auto w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mb-6 animate-pulse">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Payment Successful!</h1>
            <p class="text-gray-300">SOSONGO KE UNWAM MFO!!!</p>
        </div>

        <!-- Transaction Details Card -->
        <div class="bg-black border border-gray-700 rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-white mb-4">Transaction Details</h2>
            
            <div class="space-y-3">
                <!-- Transaction ID -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Transaction ID:</span>
                    <span class="text-white font-mono text-sm">{{ $transactionId }}</span>
                </div>
                
                <!-- Amount -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Amount:</span>
                    <span class="text-green-400 font-bold">₦{{ number_format($amount) }}</span>
                </div>
                
                <!-- Donation Type -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Donation Type:</span>
                    <span class="text-white">
                        @if($type === 'project')
                            Project Donation
                        @else
                            Foundation Donation
                        @endif
                    </span>
                </div>
                
                <!-- Payment Method -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Payment Method:</span>
                    <span class="text-white capitalize">
                        @switch($paymentMethod)
                            @case('card')
                                Debit/Credit Card
                                @break
                            @case('transfer')
                                Bank Transfer
                                @break
                            @case('ussd')
                                USSD
                                @break
                            @case('qr')
                                QR Code
                                @break
                            @default
                                {{ $paymentMethod }}
                        @endswitch
                    </span>
                </div>
                
                <!-- Date -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Date:</span>
                    <span class="text-white">{{ now()->format('M d, Y - h:i A') }}</span>
                </div>
            </div>
        </div>

        <!-- Thank You Message -->
        <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-white mb-2">Sosongo, {{ $name }}!</h3>
            <p class="text-orange-100 text-sm">
                Your donation will help us preserve and promote African art and culture. 
                A receipt has been sent to <strong>{{ $email }}</strong>.
            </p>
        </div>

        <!-- Impact Message -->
        <div class="bg-gray-800 rounded-lg p-6 mb-6">
            <div class="flex items-start">
                <div class="bg-blue-600 p-2 rounded-full mr-4 mt-1">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-1">Your Impact</h4>
                    <p class="text-gray-300 text-sm">
                        Your contribution of ₦{{ number_format($amount) }} will directly support our cultural preservation programs, 
                        artist development initiatives, and community outreach efforts.
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <button onclick="goHome()" class="w-full px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors font-medium">
                Return to Home
            </button>
            
            <div class="flex gap-3">
                <button onclick="downloadReceipt()" class="flex-1 px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium text-sm">
                    Download Receipt
                </button>
                <button onclick="shareSuccess()" class="flex-1 px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium text-sm">
                    Share
                </button>
            </div>
        </div>

        <!-- Auto Redirect Notice -->
        <div class="text-center mt-6">
            <p class="text-gray-400 text-sm">
                You will be redirected to the home page in <span id="countdown">10</span> seconds
            </p>
        </div>
    </div>
</div>

<script>
// Auto redirect countdown
let countdown = 10;
const countdownElement = document.getElementById('countdown');

const timer = setInterval(() => {
    countdown--;
    countdownElement.textContent = countdown;
    
    if (countdown <= 0) {
        clearInterval(timer);
        goHome();
    }
}, 1000);

function goHome() {
    clearInterval(timer);
    window.location.href = '/';
}

function downloadReceipt() {
    // In a real implementation, this would generate and download a PDF receipt
    alert('Receipt download functionality would be implemented here');
}

function shareSuccess() {
    if (navigator.share) {
        navigator.share({
            title: 'I just donated to Anyen Iyak Foundation!',
            text: 'I just made a donation to support African art and culture preservation. Join me in making a difference!',
            url: window.location.origin
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const text = 'I just donated to Anyen Iyak Foundation to support African art and culture preservation!';
        const url = window.location.origin;
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(`${text} ${url}`);
            alert('Share text copied to clipboard!');
        } else {
            alert('Share functionality not supported on this browser');
        }
    }
}

// Prevent accidental page refresh
window.addEventListener('beforeunload', function(e) {
    e.preventDefault();
    e.returnValue = '';
});
</script>
