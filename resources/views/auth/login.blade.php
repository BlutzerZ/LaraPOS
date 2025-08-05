@extends('layout.auth')

@section('content')
    <!-- Login Header -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
        <p class="text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Field -->
        <div class="flex flex-col gap-4">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
            </label>
            <div class="relative">
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    autocomplete="email" autofocus
                    class="input-focus w-full px-4 py-4 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base @error('email') border-red-500 @enderror"
                    placeholder="Masukkan email Anda">
                @error('email')
                    <div class="absolute -bottom-6 left-0 text-red-500 text-sm">
                        <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="pt-2 pb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2 text-blue-600"></i>Password
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                        class="input-focus w-full px-4 py-4 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base @error('password') border-red-500 @enderror"
                        placeholder="Masukkan password Anda">
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i id="password-icon" class="fas fa-eye"></i>
                    </button>
                    @error('password')
                        <div class="absolute -bottom-6 left-0 text-red-500 text-sm">
                            <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="btn-hover w-full py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold rounded-xl transition-all duration-200 text-base">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Masuk
            </button>
    </form>
    </div>
@endsection


@section('js-custom')
    <script>
        // Toggle password visibility
        function togglePassword() {
            const $passwordInput = $('#password');
            const $passwordIcon = $('#password-icon');

            if ($passwordInput.attr('type') === 'password') {
                $passwordInput.attr('type', 'text');
                $passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $passwordInput.attr('type', 'password');
                $passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        }

        // Auto-hide flash messages
        setTimeout(function() {
            $('.bg-red-100, .bg-green-100').each(function() {
                $(this).css('transition', 'opacity 0.5s ease-out').css('opacity', '0');
                setTimeout(() => $(this).remove(), 500);
            });
        }, 5000);

        // Add loading state to form submission
        $('form').on('submit', function(e) {
            const $submitBtn = $(this).find('button[type="submit"]');
            $submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...');
            $submitBtn.prop('disabled', true);
        });
    </script>
@endsection
