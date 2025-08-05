<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Kasir - Dashboard Admin POS</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            .sidebar-item.active {
                background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
                color: white;
                transform: scale(1.02);
            }

            .category-btn.active {
                background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
                color: white;
            }

            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                }

                .sidebar.open {
                    transform: translateX(0);
                }
            }
        </style>
    </head>

    <body class="bg-gray-50">
        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="md:hidden fixed top-4 left-4 z-50 bg-white p-3 rounded-xl shadow-lg border">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Sidebar -->
        @include('layout.partials.dashboard.sidebar')

        <!-- Main Content -->
        <div class="md:ml-64 min-h-screen">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b px-4 md:px-6 py-4">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">💳 Kasir POS</h1>
            </header>

            <!-- Flash Messages -->
            @if (session('success'))
                <div
                    class="alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 md:mx-6 mt-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 md:mx-6 mt-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Kasir Content -->
            @yield('content')
        </div>

        @yield('js-custom')
    </body>

</html>
