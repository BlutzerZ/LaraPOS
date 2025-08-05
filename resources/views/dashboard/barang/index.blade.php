@extends('layout.dashboard')

@section('content')
    <div class="p-4 md:p-6">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">📦 Daftar Produk</h2>
                <a href="{{ route('dashboard.barang.create') }}"
                    class="px-4 md:px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl hover:opacity-90 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Barang
                </a>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-2xl shadow-lg border p-4 md:p-6">
                <form method="GET" action="{{ route('dashboard.barang.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                            class="w-full pl-12 pr-4 py-3 md:py-4 border rounded-xl focus:ring-2 focus:ring-blue-500 text-base">
                    </div>

                    <button type="submit"
                        class="px-6 py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-2xl shadow-lg border overflow-hidden">
                @if ($barangs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-900">Kode</th>
                                    <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama</th>
                                    <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-900">Harga</th>
                                    <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($barangs as $barang)
                                    <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-4 md:px-6 py-4 font-semibold text-gray-900 text-sm md:text-base">
                                            {{ $barang->kode_barang }}
                                        </td>
                                        <td class="px-4 md:px-6 py-4 font-semibold text-gray-900 text-sm md:text-base">
                                            {{ $barang->nama_barang }}
                                        </td>
                                        <td class="px-4 md:px-6 py-4 font-semibold text-green-600 text-sm md:text-base">
                                            Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 md:px-6 py-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('dashboard.barang.edit', $barang->id) }}"
                                                    class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">
                                                    <i class="fas fa-edit text-xs md:text-sm"></i>
                                                </a>
                                                <button
                                                    onclick="confirmDelete({{ $barang->id }}, '{{ $barang->nama_barang }}')"
                                                    class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                                    <i class="fas fa-trash text-xs md:text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t">
                        {{ $barangs->links() }}
                    </div>
                @else
                    <!-- No Products Found -->
                    <div class="text-center py-16">
                        <div class="text-4xl md:text-6xl mb-4">📦</div>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-600 mb-2">Tidak ada produk ditemukan</h3>
                        <p class="text-gray-500 text-sm md:text-base mb-4">
                            @if (request('search'))
                                Coba ubah kata kunci pencarian Anda atau tambahkan produk baru.
                            @else
                                Belum ada produk yang ditambahkan
                            @endif
                        </p>
                        <a href="{{ route('dashboard.barang.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Produk Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-auto mt-20">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Produk</h3>
                <p class="text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus produk <strong id="product-name"></strong>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex space-x-3">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 py-3 bg-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-400 transition-all duration-200">
                        Batal
                    </button>
                    <form id="delete-form" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-200">
                            Hapus
                        </button>
                    </form>
                </div>
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

        // Delete confirmation
        function confirmDelete(productId, productName) {
            $('#product-name').text(productName);
            var url = "{{ url('dashboard/barang/delete') }}/" + productId;
            $('#delete-form').attr('action', url);
            $('#delete-modal').show();
        }

        function closeDeleteModal() {
            $('#delete-modal').hide();
        }

        // Close modal when clicking outside
        $('#delete-modal').click(function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close sidebar when clicking outside on mobile
        $(document).click(function(e) {
            if ($(window).width() < 768 && !$(e.target).closest('#sidebar, #mobile-menu-btn').length) {
                $('#sidebar').removeClass('open');
            }
        });

        // Auto-hide alerts
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    </script>
@endsection
