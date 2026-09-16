<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"> --}}
        <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/dgsctl247/image/upload/v1758843914/aifac_logo_nloews.png" sizes="16x16">

        <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-black">
        <div class="min-h-screen">
            <!-- Header -->
            @include('components.header')

            <!-- Page Content -->
            <main class="pt-16">
                {{ $slot }}
            </main>

            <!-- Footer -->
            @include('components.footer')

            <!-- Donation Modals -->
            @include('components.donation-type-modal')
            @include('components.payment-details-modal')

            <!-- Summit Ticket Modals -->
            @include('components.ticket-type-modal')
            @include('components.ticket-details-modal')
        </div>

        @livewireScripts
        
        <!-- Donation Modal Scripts -->
        <script>
        // Donation Type Modal Functions
        function openDonationTypeModal() {
            const modal = document.getElementById('donationTypeModal');
            const content = document.getElementById('donationTypeModalContent');
            
            if (modal && content) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Animate in
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                console.error('Modal elements not found!', {modal, content});
            }
        }

        function closeDonationTypeModal() {
            const modal = document.getElementById('donationTypeModal');
            const content = document.getElementById('donationTypeModalContent');
            
            if (modal && content) {
                // Animate out
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 300);
            }
        }

        function selectFoundationDonation() {
            closeDonationTypeModal();
            // Open payment details modal
            setTimeout(() => {
                openPaymentDetailsModal('foundation');
            }, 300);
        }

        function selectProjectDonation() {
            closeDonationTypeModal();
            // Redirect to projects page
            setTimeout(() => {
                window.location.href = '/projects';
            }, 300);
        }

        // Payment Details Modal Functions
        let currentDonationType = 'foundation';
        let currentProjectId = null;

        function openPaymentDetailsModal(donationType = 'foundation', projectId = null) {
            currentDonationType = donationType;
            currentProjectId = projectId;
            
            const modal = document.getElementById('paymentDetailsModal');
            const content = document.getElementById('paymentDetailsModalContent');
            const typeText = document.getElementById('donationTypeText');
            
            if (modal && content && typeText) {
                // Update modal title based on donation type
                if (donationType === 'project' && projectId) {
                    typeText.textContent = `Donating to Project #${projectId}`;
                } else {
                    typeText.textContent = 'Donating to the Foundation';
                }
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Animate in
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            }
        }

        function closePaymentDetailsModal() {
            const modal = document.getElementById('paymentDetailsModal');
            const content = document.getElementById('paymentDetailsModalContent');
            
            if (modal && content) {
                // Animate out
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    // Reset form
                    const form = document.getElementById('paymentDetailsForm');
                    if (form) form.reset();
                }, 300);
            }
        }

        function setAmount(amount) {
            const amountInput = document.getElementById('donationAmount');
            if (amountInput) {
                amountInput.value = amount;
                
                // Add visual feedback
                const buttons = document.querySelectorAll('[onclick^="setAmount"]');
                buttons.forEach(btn => btn.classList.remove('bg-orange-600'));
                event.target.classList.add('bg-orange-600');
                
                setTimeout(() => {
                    event.target.classList.remove('bg-orange-600');
                }, 1000);
            }
        }

        function proceedToPayment() {
            const form = document.getElementById('paymentDetailsForm');
            if (!form) return;
            
            const formData = new FormData(form);
            
            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Get form data
            const paymentData = {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                amount: formData.get('amount'),
                message: formData.get('message'),
                type: currentDonationType,
                projectId: currentProjectId
            };
            
            // Validate minimum amount
            if (parseFloat(paymentData.amount) < 100) {
                alert('Minimum donation amount is ₦100');
                return;
            }
            
            // Close modal and proceed to payment gateway
            closePaymentDetailsModal();
            
            setTimeout(() => {
                initiatePayment(paymentData);
            }, 300);
        }

        function initiatePayment(paymentData) {
            // For now, redirect to a payment summary page
            const params = new URLSearchParams({
                name: paymentData.name,
                email: paymentData.email,
                phone: paymentData.phone,
                amount: paymentData.amount,
                type: paymentData.type,
                projectId: paymentData.projectId || ''
            });
            
            window.location.href = `/payment-gateway?${params.toString()}`;
        }

        // Close modals when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const donationModal = document.getElementById('donationTypeModal');
            const paymentModal = document.getElementById('paymentDetailsModal');
            const ticketTypeModal = document.getElementById('ticketTypeModal');
            const ticketDetailsModal = document.getElementById('ticketDetailsModal');
            
            if (donationModal) {
                donationModal.addEventListener('click', function(e) {
                    if (e.target === donationModal) {
                        closeDonationTypeModal();
                    }
                });
            }
            
            if (paymentModal) {
                paymentModal.addEventListener('click', function(e) {
                    if (e.target === paymentModal) {
                        closePaymentDetailsModal();
                    }
                });
            }

            if (ticketTypeModal) {
                ticketTypeModal.addEventListener('click', function(e) {
                    if (e.target === ticketTypeModal) {
                        closeTicketTypeModal();
                    }
                });
            }

            if (ticketDetailsModal) {
                ticketDetailsModal.addEventListener('click', function(e) {
                    if (e.target === ticketDetailsModal) {
                        closeTicketDetailsModal();
                    }
                });
            }
        });

        // ── Summit ticket purchase flow ─────────────────────────────────
        const summitTicketCatalog = @json(config('summit.tickets'));
        let currentTicketType = null;

        function animateModalOpen(modal, content) {
            if (!modal || !content) return;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function animateModalClose(modal, content, onClosed) {
            if (!modal || !content) return;
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                if (typeof onClosed === 'function') onClosed();
            }, 300);
        }

        function openTicketTypeModal() {
            animateModalOpen(
                document.getElementById('ticketTypeModal'),
                document.getElementById('ticketTypeModalContent')
            );
        }

        function closeTicketTypeModal() {
            animateModalClose(
                document.getElementById('ticketTypeModal'),
                document.getElementById('ticketTypeModalContent')
            );
        }

        function selectTicketPass(ticketType) {
            currentTicketType = ticketType;
            closeTicketTypeModal();
            setTimeout(() => openTicketDetailsModal(ticketType), 300);
        }

        function openTicketDetailsModal(ticketType) {
            currentTicketType = ticketType;
            const pass = summitTicketCatalog[ticketType];
            const summary = document.getElementById('ticketPassSummary');
            const amountDisplay = document.getElementById('ticketAmountDisplay');

            if (pass && summary && amountDisplay) {
                summary.textContent = pass.name + ' — ' + pass.day_label;
                amountDisplay.textContent = '₦' + Number(pass.price).toLocaleString();
            }

            animateModalOpen(
                document.getElementById('ticketDetailsModal'),
                document.getElementById('ticketDetailsModalContent')
            );
        }

        function closeTicketDetailsModal() {
            animateModalClose(
                document.getElementById('ticketDetailsModal'),
                document.getElementById('ticketDetailsModalContent'),
                () => {
                    const form = document.getElementById('ticketDetailsForm');
                    if (form) form.reset();
                }
            );
        }

        async function proceedToTicketPayment() {
            const form = document.getElementById('ticketDetailsForm');
            const btn = document.getElementById('ticketProceedBtn');
            if (!form || !currentTicketType) return;

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = new FormData(form);
            const payload = {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                type: 'ticket',
                ticket_type: currentTicketType,
                source: 'livewire_home',
            };

            const originalLabel = btn ? btn.textContent : '';
            if (btn) {
                btn.disabled = true;
                btn.textContent = 'Initializing…';
            }

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch('/payment/initialize', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf || '',
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (result.success && result.authorization_url) {
                    window.location.href = result.authorization_url;
                    return;
                }

                alert(result.message || 'Failed to start payment. Please try again.');
            } catch (error) {
                console.error('Ticket payment error:', error);
                alert('An error occurred while starting payment. Please try again.');
            } finally {
                if (btn) {
                    btn.disabled = false;
                    btn.textContent = originalLabel || 'Proceed to Payment';
                }
            }
        }
        </script>
    </body>
</html> 