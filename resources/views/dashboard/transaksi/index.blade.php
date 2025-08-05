@extends('layout.dashboard')

@section('content')
    <div class="p-4 md:p-6">
        <div class="space-y-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <div class="bg-white rounded-2xl shadow-lg border p-4 md:p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-receipt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_transaksi'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border p-4 md:p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-money-bill-wave text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                            <p class="text-2xl font-bold text-green-600">Rp
                                {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border p-4 md:p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Barang</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_barang'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border p-4 md:p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Rata-rata</p>
                            <p class="text-2xl font-bold text-purple-600">Rp
                                {{ number_format($stats['rata_transaksi'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">🧾 Riwayat Transaksi</h2>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-2xl shadow-lg border p-4 md:p-6">
                <form method="GET" action="{{ route('dashboard.transaksi.index') }}"
                    class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari berdasarkan ID transaksi..."
                            class="w-full pl-12 pr-4 py-3 md:py-4 border rounded-xl focus:ring-2 focus:ring-blue-500 text-base">
                    </div>
                    <div class="flex gap-2">
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 text-base">
                        <button type="submit"
                            class="px-6 py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white rounded-2xl shadow-lg border overflow-hidden">
                @if ($transaksis->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-900">ID Transaksi
                                    </th>
                                    <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                                    <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-900">Barang</th>
                                    <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-900">Total</th>
                                    <th class="px-4 md:px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($transaksis as $transaksi)
                                    <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-4 md:px-6 py-4 font-semibold text-blue-600 text-sm md:text-base">
                                            {{ $transaksi->id }}
                                        </td>
                                        <td class="px-4 md:px-6 py-4 text-gray-700 text-sm md:text-base">
                                            {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 md:px-6 py-4 text-gray-700 text-sm md:text-base">
                                            {{ $transaksi->total_barang }} barang
                                        </td>
                                        <td class="px-4 md:px-6 py-4 font-semibold text-green-600 text-sm md:text-base">
                                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 md:px-6 py-4">
                                            <div class="flex space-x-2">
                                                <button onclick="showTransactionDetail({{ $transaksi->id }})"
                                                    class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">
                                                    <i class="fas fa-eye text-xs md:text-sm"></i>
                                                </button>
                                                <button onclick="confirmDelete({{ $transaksi->id }})"
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
                        {{ $transaksis->links() }}
                    </div>
                @else
                    <!-- No Transactions Found -->
                    <div class="text-center py-16">
                        <div class="text-4xl md:text-6xl mb-4">🧾</div>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-600 mb-2">Tidak ada transaksi ditemukan</h3>
                        <p class="text-gray-500 text-sm md:text-base mb-4">
                            @if (request('search') || request('status') || request('date'))
                                Coba ubah kata kunci pencarian atau filter
                            @else
                                Belum ada transaksi yang tercatat
                            @endif
                        </p>
                        <a href="{{ route('dashboard.kasir.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-200">
                            <i class="fas fa-cash-register mr-2"></i>
                            Mulai Transaksi
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Transaction Detail Modal -->
    <div id="detail-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md max-h-[90vh] overflow-y-auto mx-auto mt-16">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Detail Transaksi</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="transaction-detail">
                <!-- Transaction detail will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Transaksi</h3>
                <p class="text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus transaksi <strong id="transaction-id"></strong>?
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

        // Show transaction detail
        function showTransactionDetail(transactionId) {
            const detailUrl = "{{ route('dashboard.transaksi.show', ':transaksi') }}".replace(':transaksi', transactionId);
            $.ajax({
                url: detailUrl,
                type: 'GET',
                success: function(data) {
                    data = data.data;
                    let transactionHtml = `
                        <div class="space-y-4">
                            <!-- Transaction Header -->
                            <div class="bg-white rounded-2xl p-4 border shadow-lg">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-600">ID Transaksi</h4>
                                        <p class="text-lg font-bold text-blue-600">${data.id || 'N/A'}</p>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="text-sm font-medium text-gray-600">Tanggal</h4>
                                        <p class="text-sm text-gray-700">${data.tanggal}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 pt-3 border-t">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-600">Total Barang</h4>
                                        <p class="text-lg font-bold text-gray-900">${data.total_barang} barang</p>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="text-sm font-medium text-gray-600">Total Harga</h4>
                                        <p class="text-xl font-bold text-green-600">Rp ${Number(data.total_harga).toLocaleString('id-ID')}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Items List -->
                            <div class="bg-white rounded-2xl p-4 border shadow-lg">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <span class="p-2 rounded-full bg-orange-100 text-orange-600 mr-3">
                                        <i class="fas fa-shopping-cart text-base"></i>
                                    </span>
                                    Detail Barang
                                </h4>
                                <div class="space-y-3">
                                    ${data.details.map(item => `
                                                                            <div class="bg-gray-50 rounded-xl p-4 border flex justify-between items-center">
                                                                                <div>
                                                                                    <h5 class="font-semibold text-gray-900">${item.nama_barang}</h5>
                                                                                    <p class="text-sm text-gray-600 mt-1">${item.jumlah} × Rp ${Number(item.harga).toLocaleString('id-ID')}</p>
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    <p class="text-lg font-bold text-green-600">Rp ${(item.harga * item.jumlah).toLocaleString('id-ID')}</p>
                                                                                </div>
                                                                            </div>
                                                                        `).join('')}
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-2xl p-4 text-white shadow-lg">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <span class="p-2 rounded-full bg-white bg-opacity-20 mr-3 text-green-600">
                                            <i class="fas fa-money-bill-wave text-base"></i>
                                        </span>
                                        <span class="font-semibold">Total Pembayaran</span>
                                    </div>
                                    <span class="text-2xl font-bold">Rp ${Number(data.total_harga).toLocaleString('id-ID')}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#transaction-detail').html(transactionHtml);
                    $('#detail-modal').show();
                },
                error: function() {
                    alert('Gagal memuat detail transaksi');
                }
            });
        }

        function closeDetailModal() {
            $('#detail-modal').hide();
        }

        // Delete confirmation
        function confirmDelete(transactionId) {
            $('#transaction-id').text(transactionId);
            var deleteUrl = "{{ route('dashboard.transaksi.delete', ':transaksi') }}".replace(':transaksi', transactionId);
            $('#delete-form').attr('action', deleteUrl);
            $('#delete-modal').show();
        }

        function closeDeleteModal() {
            $('#delete-modal').hide();
        }

        // Close modals when clicking outside
        $('.fixed').click(function(e) {
            if (e.target === this) {
                $(this).hide();
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
