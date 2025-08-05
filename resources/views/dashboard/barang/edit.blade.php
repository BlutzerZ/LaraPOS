@extends('layout.dashboard')

@section('content')
    <div class="p-4 md:p-6">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center mb-4">
                    <a href="{{ route('dashboard.barang.index') }}"
                        class="mr-4 p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">✏️ Edit Produk</h2>
                </div>
                <p class="text-gray-600">Edit informasi produk <strong>{{ $barang->name }}</strong></p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-lg border p-6 md:p-8">
                <form method="POST" action="{{ route('dashboard.barang.update', $barang->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="kode_barang" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kode_barang') border-red-500 @enderror"
                            placeholder="Masukkan kode barang" required>
                        @error('kode_barang')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_barang" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_barang') border-red-500 @enderror"
                            placeholder="Masukkan nama barang" required>
                        @error('nama_barang')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                            <input type="number" id="harga" name="harga"
                                value="{{ old('harga', $barang->harga) }}"
                                class="w-full pl-12 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('harga') border-red-500 @enderror"
                                placeholder="0" min="0" required>
                        </div>
                        @error('harga')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                        <a href="{{ route('dashboard.barang.index') }}"
                            class="flex-1 py-3 px-6 bg-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-400 transition-all duration-200 text-center">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 py-3 px-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:opacity-90 transform hover:scale-105 transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Update Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js-custom')
    <script>
        // Mobile menu toggle
        $('#mobile-menu-btn').click(function() {
            $('#sidebar').toggleClass('open');
        });

        // Format price input
        $('#price').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            $(this).val(value);
        });

        // Close sidebar when clicking outside on mobile
        $(document).click(function(e) {
            if ($(window).width() < 768 && !$(e.target).closest('#sidebar, #mobile-menu-btn').length) {
                $('#sidebar').removeClass('open');
            }
        });
    </script>
@endsection
