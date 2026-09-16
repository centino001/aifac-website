<div class="min-h-screen bg-black flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <div class="mx-auto w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mb-6 animate-pulse">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">
                {{ $this->isTicket() ? 'Ticket Confirmed!' : 'Payment Successful!' }}
            </h1>
            <p class="text-gray-300">SOSONGO KE UNWAM MFO!!!</p>
        </div>

        <div class="bg-black border border-gray-700 rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-white mb-4">
                {{ $this->isTicket() ? 'Ticket Details' : 'Transaction Details' }}
            </h2>

            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Transaction ID:</span>
                    <span class="text-white font-mono text-sm">{{ $transactionId }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Amount:</span>
                    <span class="text-green-400 font-bold">₦{{ number_format($amount) }}</span>
                </div>

                @if($this->isTicket())
                    <div class="flex justify-between items-center gap-4">
                        <span class="text-gray-300 shrink-0">Pass:</span>
                        <span class="text-[#f3ead8] text-right">{{ $passName ?? 'Summit Pass' }}</span>
                    </div>
                    @if($ticketCode)
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-gray-300 shrink-0">Ticket code:</span>
                            <span class="text-white font-mono text-sm">{{ $ticketCode }}</span>
                        </div>
                    @endif
                @else
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
                @endif

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
                            @default
                                {{ $paymentMethod }}
                        @endswitch
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Date:</span>
                    <span class="text-white">{{ now()->format('M d, Y - h:i A') }}</span>
                </div>
            </div>
        </div>

        @if($this->isTicket())
            <div class="bg-gradient-to-r from-[#f3ead8] to-[#e8d9bf] rounded-lg p-6 mb-6 text-[#1a120c]">
                <h3 class="text-lg font-semibold mb-2">Sosongo, {{ $name }}!</h3>
                <p class="text-sm">
                    Your e-ticket with a scannable QR code has been sent to
                    <strong>{{ $email }}</strong>. Please present it at the entrance for check-in.
                </p>
            </div>

            <div class="bg-gray-800 rounded-lg p-6 mb-6">
                <h4 class="font-semibold text-white mb-1">What’s next</h4>
                <p class="text-gray-300 text-sm">
                    Check your inbox (and spam folder) for the confirmation email. Keep the QR code handy on your phone for summit entry at New Culture Studios, Ibadan.
                </p>
            </div>
        @else
            <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-white mb-2">Sosongo, {{ $name }}!</h3>
                <p class="text-orange-100 text-sm">
                    Your donation will help us preserve and promote African art and culture.
                    A receipt has been sent to <strong>{{ $email }}</strong>.
                </p>
            </div>

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
        @endif

        <div class="space-y-3">
            <button onclick="goHome()" class="w-full px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors font-medium">
                Return to Home
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-gray-400 text-sm">
                You will be redirected to the home page in <span id="countdown">10</span> seconds
            </p>
        </div>
    </div>
</div>

<script>
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
</script>
