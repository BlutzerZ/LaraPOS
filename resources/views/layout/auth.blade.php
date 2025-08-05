<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Login - LaraPOS</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            .login-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .card-shadow {
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }

            .input-focus:focus {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
            }

            .btn-hover:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .floating-animation {
                animation: float 6s ease-in-out infinite;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-20px);
                }
            }
        </style>
    </head>

    <body class="login-bg min-h-screen flex items-center justify-center p-4">
        <!-- Background Decorations -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full floating-animation"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-5 rounded-full floating-animation"
                style="animation-delay: -3s;"></div>
            <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white opacity-10 rounded-full floating-animation"
                style="animation-delay: -1s;"></div>
        </div>

        <!-- Login Container -->
        <div class="relative z-10 w-full max-w-md">
            <!-- Logo/Header Section -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-lg mb-4">
                    <i class="fas fa-cash-register text-3xl text-blue-600"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">💳 LaraPOS</h1>
                <p class="text-blue-100 text-lg">Sistem Point of Sale</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl card-shadow p-8">
                <!-- Flash Messages -->
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-blue-100 text-sm">
                    © {{ date('Y') }} LaraPOS. Dilindungi hak cipta oleh
                    <a href="https://github.com/BlutzerZ" target="_blank"
                        class="underline hover:text-blue-300">BlutzerZ</a>.
                </p>
            </div>
        </div>

        @yield('js-custom')
    </body>

</html>
