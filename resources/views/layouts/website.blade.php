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
        });
        </script>
    </body>
</html> 