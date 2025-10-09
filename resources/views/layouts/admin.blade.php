<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/dgsctl247/image/upload/v1758843246/aifac_logo_wjjkzk.png" sizes="16x16">
    <title>{{ $title ?? 'Admin Panel' }} - AIFAC</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white font-sans antialiased">
    <div class="min-h-screen">
        {{ $slot }}
    </div>

    <!-- Display Success Messages -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#ea580c',
                    background: 'black',
                    color: '#ffffff',
                    customClass: {
                        popup: 'swal-orange-theme',
                        confirmButton: 'swal-orange-button'
                    }
                });
            });
        </script>
    @endif

    <!-- Display Error Messages -->
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#ea580c',
                    background: 'black',
                    color: '#ffffff',
                    customClass: {
                        popup: 'swal-orange-theme',
                        confirmButton: 'swal-orange-button'
                    }
                });
            });
        </script>
    @endif

    <!-- Debug: Display all validation errors -->
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let errorList = '';
                @foreach ($errors->all() as $error)
                    errorList += '• {{ addslashes($error) }}\n';
                @endforeach
                
                Swal.fire({
                    title: 'Validation Errors',
                    text: errorList,
                    icon: 'warning',
                    confirmButtonColor: '#ea580c',
                    background: 'black',
                    color: '#ffffff',
                    customClass: {
                        popup: 'swal-orange-theme',
                        confirmButton: 'swal-orange-button'
                    }
                });
            });
        </script>
    @endif

    <!-- Session Expiration Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle Livewire session expiration
            document.addEventListener('livewire:response', function(event) {
                if (event.detail.status === 401) {
                    Swal.fire({
                        title: 'Session Expired',
                        text: 'Your session has expired. Please login again.',
                        icon: 'warning',
                        confirmButtonColor: '#ea580c',
                        background: 'black',
                        color: '#ffffff',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        customClass: {
                            popup: 'swal-orange-theme'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/admin/login';
                        }
                    });
                }
            });

            // Handle AJAX/Fetch session expiration
            window.addEventListener('unhandledrejection', function(event) {
                if (event.reason && event.reason.status === 401) {
                    Swal.fire({
                        title: 'Session Expired',
                        text: 'Your session has expired. Please login again.',
                        icon: 'warning',
                        confirmButtonColor: '#ea580c',
                        background: 'black',
                        color: '#ffffff',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        customClass: {
                            popup: 'swal-orange-theme'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/admin/login';
                        }
                    });
                }
            });

            // Handle network errors and redirect appropriately
            window.addEventListener('error', function(event) {
                if (event.error && event.error.message && event.error.message.includes('Route [login] not defined')) {
                    window.location.href = '/admin/login';
                }
            });
        });
    </script>

    <style>
        .swal-orange-theme {
            border: 2px solid #ea580c !important;
        }
        
        .swal-orange-theme .swal2-confirm {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(234, 88, 12, 0.4) !important;
        }
        
        .swal-orange-theme .swal2-confirm:hover {
            background: linear-gradient(135deg, #dc2626 0%, #ea580c 100%) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(234, 88, 12, 0.6) !important;
        }
    </style>
</body>
</html> 