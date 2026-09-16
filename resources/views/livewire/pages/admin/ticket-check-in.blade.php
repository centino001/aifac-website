<div class="min-h-screen bg-black flex" x-data="{ sidebarOpen: false }">
    <x-admin.sidebar active="ticket_checkin" />

<div class="flex-1 flex flex-col min-w-0">
        <header class="bg-black shadow-lg border-b border-orange-600 px-4 lg:px-6 py-3 lg:py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-400 hover:text-white mr-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-lg lg:text-xl font-bold text-white">GBSAAC 2026 Check-In</h2>
                        <p class="text-xs text-gray-400">Scan QR or enter ticket code</p>
                    </div>
                </div>
                <div class="text-right text-sm">
                    <p class="text-[#f3ead8] font-semibold">{{ $checkedInCount }} / {{ $paidCount }} checked in</p>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-6 space-y-6 overflow-y-auto">
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="border border-orange-600/40 rounded-lg p-4 bg-gray-950">
                    <h3 class="text-white font-semibold mb-3">Camera scanner</h3>
                    <div id="qr-reader" class="overflow-hidden rounded-lg bg-black"></div>
                    <p class="text-xs text-gray-400 mt-3">Allow camera access, then point at the attendee’s e-ticket QR.</p>
                    <button type="button" id="stop-scanner-btn"
                            class="mt-3 text-sm text-gray-300 hover:text-white underline">
                        Stop camera
                    </button>
                </div>

                <div class="border border-orange-600/40 rounded-lg p-4 bg-gray-950">
                    <h3 class="text-white font-semibold mb-3">Manual entry</h3>
                    <form wire:submit.prevent="checkIn" class="space-y-3"
                          x-data
                          x-init="$nextTick(() => $refs.codeSuffix?.focus())">
                        <label class="block text-sm text-gray-300" for="codeSuffix">Ticket code</label>
                        <div class="flex rounded-lg overflow-hidden border border-gray-600 focus-within:ring-2 focus-within:ring-orange-500">
                            <span class="px-3 py-2 bg-gray-900 text-gray-400 font-mono text-sm border-r border-gray-600 select-none">{{ $codePrefix }}</span>
                            <input id="codeSuffix"
                                   type="text"
                                   x-ref="codeSuffix"
                                   wire:model="codeSuffix"
                                   autocomplete="off"
                                   spellcheck="false"
                                   maxlength="16"
                                   placeholder="XXXXXX"
                                   class="flex-1 min-w-0 px-3 py-2 bg-gray-800 border-0 text-white font-mono uppercase tracking-wider focus:outline-none">
                        </div>
                        <p class="text-xs text-gray-500">Type only the last segment. Camera scans still use the full QR payload.</p>
                        @error('scanInput') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
                        @error('codeSuffix') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
                        <button type="submit"
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2.5 rounded-lg">
                            Check in
                        </button>
                    </form>

                    @if($lastResult)
                        <div class="mt-4 rounded-lg p-4 border {{ $lastResult['success'] ? 'border-green-500 bg-green-900/30' : 'border-red-500 bg-red-900/30' }}">
                            <p class="font-semibold {{ $lastResult['success'] ? 'text-green-300' : 'text-red-300' }}">
                                {{ $lastResult['message'] }}
                            </p>
                            @if(!empty($lastResult['attendee_name']))
                                <p class="text-white mt-2">{{ $lastResult['attendee_name'] }}</p>
                                <p class="text-gray-300 text-sm">{{ $lastResult['pass_name'] ?? '' }}</p>
                                <p class="text-gray-400 text-sm">{{ $lastResult['day_label'] ?? '' }}</p>
                                <p class="text-gray-400 text-xs font-mono mt-1">{{ $lastResult['code'] ?? '' }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('livewire:navigated', startQrScanner);
document.addEventListener('DOMContentLoaded', startQrScanner);

let html5QrCode = null;
let scanningLock = false;

async function startQrScanner() {
    const el = document.getElementById('qr-reader');
    if (!el || typeof Html5Qrcode === 'undefined') return;
    if (html5QrCode) return;

    html5QrCode = new Html5Qrcode('qr-reader');
    try {
        await html5QrCode.start(
            { facingMode: 'environment' },
            { fps: 8, qrbox: { width: 240, height: 240 } },
            async (decodedText) => {
                if (scanningLock) return;
                scanningLock = true;
                @this.set('scanInput', decodedText);
                await @this.checkIn();
                setTimeout(() => { scanningLock = false; }, 2000);
            },
            () => {}
        );
    } catch (e) {
        console.warn('Camera scanner unavailable:', e);
        el.innerHTML = '<p class="text-sm text-gray-400 p-4">Camera unavailable. Use manual entry.</p>';
    }
}

document.getElementById('stop-scanner-btn')?.addEventListener('click', async () => {
    if (html5QrCode) {
        try { await html5QrCode.stop(); } catch (e) {}
        html5QrCode = null;
    }
});

document.addEventListener('livewire:init', () => {
    Livewire.on('checkin-feedback', ({ success, message }) => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: success ? 'Checked in' : 'Notice',
                text: message,
                icon: success ? 'success' : 'warning',
                confirmButtonColor: '#ea580c',
                background: 'black',
                color: '#ffffff',
                timer: success ? 1800 : undefined,
            });
        }
    });
});
</script>
@endpush
