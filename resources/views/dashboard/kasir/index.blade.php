@extends('layout.dashboard')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
        <!-- Mobile Cart Summary -->
        <div class="lg:hidden bg-white border-b p-4">
            <div
                class="bg-gradient-to-r from-green-500 to-teal-600 text-white px-4 py-3 rounded-xl flex items-center justify-between">
                <span class="font-semibold">Keranjang: <span id="mobile-cart-count">0</span> item</span>
                <span class="font-bold">Rp <span id="mobile-cart-total">0</span></span>
            </div>
        </div>

        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-6">
                <!-- Product Selection -->
                <div class="lg:col-span-8">
                    <!-- Products Grid -->
                    <div id="products-grid"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4 mb-20">
                        @foreach ($barangs as $barang)
                            <div class="product-card bg-white rounded-2xl shadow-lg border overflow-hidden hover:shadow-xl transition-all duration-300 hover:scale-105"
                                data-id="{{ $barang->id }}" data-name="{{ $barang->nama_barang }}">
                                <div class="p-3 md:p-4">
                                    <div class="flex justify-between items-start mb-2 md:mb-3">
                                        <h3
                                            class="font-bold text-sm md:text-lg text-gray-900 leading-tight flex-1 min-w-0 pr-2">
                                            {{ $barang->nama_barang }}
                                        </h3>
                                    </div>
                                    <div class="mb-3 md:mb-4">
                                        <p class="text-lg md:text-2xl font-bold text-green-600 mb-1 md:mb-2">Rp
                                            {{ number_format($barang->harga, 0, ',', '.') }}</p>
                                    </div>

                                    <div class="cart-controls-{{ $barang->id }}">
                                        <button
                                            onclick="addToCart({{ $barang->id }}, '{{ $barang->nama_barang }}', {{ $barang->harga }})"
                                            class="add-btn-{{ $barang->id }} w-full py-2 md:py-3 rounded-xl font-bold text-sm md:text-base transition-all duration-200 bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 shadow-lg">
                                            ➕ Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($barangs->isEmpty())
                        <div class="text-center py-16">
                            <div class="text-4xl md:text-6xl mb-4">📦</div>
                            <h3 class="text-lg md:text-xl font-semibold text-gray-600 mb-2">Belum ada produk</h3>
                            <p class="text-gray-500 text-sm md:text-base mb-4">Tambahkan produk terlebih dahulu untuk
                                memulai transaksi</p>
                            <a href="{{ route('products.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-200">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Produk
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Cart Sidebar -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl shadow-xl border overflow-hidden sticky top-4">
                        <!-- Cart Header -->
                        <div class="bg-gradient-to-r from-green-500 to-teal-600 text-white p-4 md:p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    <span class="font-bold text-base md:text-lg">Keranjang</span>
                                </div>
                                <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                                    <span id="cart-count" class="font-bold">0</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 md:p-6">
                            <!-- Empty Cart -->
                            <div id="empty-cart" class="text-center py-8 md:py-12">
                                <div class="text-4xl md:text-6xl mb-4">🛒</div>
                                <p class="text-gray-500 font-medium text-sm md:text-base">Keranjang masih kosong</p>
                                <p class="text-xs md:text-sm text-gray-400 mt-2">Pilih produk untuk memulai transaksi</p>
                            </div>

                            <!-- Cart Items -->
                            <div id="cart-items" class="space-y-4 mb-6 max-h-64 md:max-h-80 overflow-y-auto hidden">
                                <!-- Cart items will be populated by JavaScript -->
                            </div>

                            <!-- Total Section -->
                            <div id="cart-total-section" class="border-t pt-6 hidden">
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg md:text-xl font-bold text-gray-900">Total:</span>
                                        <span class="text-xl md:text-3xl font-bold text-green-600">
                                            Rp <span id="cart-total">0</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Payment Method Selection -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Metode Pembayaran:</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <button type="button"
                                            class="payment-method active px-3 py-2 border-2 border-green-500 bg-green-50 text-green-700 rounded-lg text-sm font-semibold transition-all"
                                            data-method="cash">
                                            💵 Tunai
                                        </button>
                                        <button type="button"
                                            class="payment-method px-3 py-2 border-2 border-gray-300 bg-white text-gray-700 rounded-lg text-sm font-semibold transition-all hover:border-gray-400"
                                            data-method="card">
                                            💳 Kartu
                                        </button>
                                        <button type="button"
                                            class="payment-method px-3 py-2 border-2 border-gray-300 bg-white text-gray-700 rounded-lg text-sm font-semibold transition-all hover:border-gray-400"
                                            data-method="qris">
                                            📱 QRIS
                                        </button>
                                        <button type="button"
                                            class="payment-method px-3 py-2 border-2 border-gray-300 bg-white text-gray-700 rounded-lg text-sm font-semibold transition-all hover:border-gray-400"
                                            data-method="transfer">
                                            🏦 Transfer
                                        </button>
                                    </div>
                                </div>

                                <button id="process-transaction"
                                    class="w-full py-3 md:py-4 bg-gradient-to-r from-green-500 to-teal-600 text-white font-bold text-base md:text-lg rounded-xl hover:opacity-90 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                    💳 Proses Pembayaran
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Cart Button -->
        <div id="mobile-cart-btn" class="lg:hidden fixed bottom-4 left-4 right-4 z-50 hidden">
            <button onclick="$('#cart-total-section').length && processTransaction()"
                class="w-full py-4 bg-gradient-to-r from-green-500 to-teal-600 text-white font-bold text-lg rounded-xl shadow-2xl flex items-center justify-between px-6">
                <div class="flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span id="mobile-cart-items">0 item</span>
                </div>
                <div class="flex items-center">
                    <span class="mr-2">Rp <span id="mobile-total">0</span></span>
                    <span>💳</span>
                </div>
            </button>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-auto mt-16">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Transaksi Berhasil!</h3>
                <p class="text-gray-600 mb-4">
                    Transaksi dengan ID <strong id="transaction-id"></strong> telah berhasil diproses.
                </p>
                <div class="space-y-3">
                    <button onclick="closeSuccessModal()"
                        class="w-full py-3 bg-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-400 transition-all duration-200">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-2xl p-8 text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <p class="text-gray-600 font-semibold">Memproses transaksi...</p>
        </div>
    </div>
@endsection

@section('js-custom')
    <script>
        let cart = [];
        let selectedPaymentMethod = 'cash';

        // Utility functions
        function formatCurrency(amount) {
            return amount.toLocaleString('id-ID');
        }

        // Cart management
        function addToCart(productId, productName, productPrice) {
            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                existingItem.quantity++;
                updateCartDisplay();
                updateProductButton(productId, existingItem.quantity);
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    quantity: 1,
                });
                updateCartDisplay();
                updateProductButton(productId, 1);
            }
        }

        function updateCartQuantity(productId, quantity) {
            const item = cart.find(item => item.id === productId);
            if (!item) return;

            if (quantity <= 0) {
                removeFromCart(productId);
                return;
            }

            item.quantity = quantity;
            updateCartDisplay();
            updateProductButton(productId, quantity);
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            updateCartDisplay();
            resetProductButton(productId);
        }

        function clearCart() {
            cart.forEach(item => resetProductButton(item.id));
            cart = [];
            updateCartDisplay();
        }

        function getTotalPrice() {
            return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        }

        function getCartItemCount() {
            return cart.reduce((total, item) => total + item.quantity, 0);
        }

        // Display functions
        function updateCartDisplay() {
            const cartCount = getCartItemCount();
            const totalPrice = getTotalPrice();

            $('#cart-count').text(cartCount);
            $('#cart-total').text(formatCurrency(totalPrice));
            $('#mobile-cart-count').text(cartCount);
            $('#mobile-cart-total').text(formatCurrency(totalPrice));
            $('#mobile-cart-items').text(cartCount + ' item');
            $('#mobile-total').text(formatCurrency(totalPrice));

            if (cart.length === 0) {
                $('#empty-cart').show();
                $('#cart-items').hide();
                $('#cart-total-section').hide();
                $('#mobile-cart-btn').hide();
            } else {
                $('#empty-cart').hide();
                $('#cart-items').show();
                $('#cart-total-section').show();
                $('#mobile-cart-btn').show();
                renderCartItems();
            }
        }

        function renderCartItems() {
            const cartItemsHtml = cart.map(item => `
            <div class="bg-gray-50 rounded-xl p-3 md:p-4 border">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-gray-900 text-sm md:text-base leading-tight truncate">${item.name}</h4>
                        <p class="text-green-600 font-semibold text-xs md:text-sm">Rp ${formatCurrency(item.price)}</p>
                    </div>
                    <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 p-1 hover:bg-red-100 rounded-lg ml-2">
                        <i class="fas fa-trash text-xs md:text-sm"></i>
                    </button>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})" class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-red-500 text-white hover:bg-red-600 flex items-center justify-center">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="w-6 md:w-8 text-center font-bold text-sm md:text-lg">${item.quantity}</span>
                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})" class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-green-500 text-white hover:bg-green-600 flex items-center justify-center">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                    <span class="font-bold text-green-600 text-sm md:text-base">Rp ${formatCurrency(item.price * item.quantity)}</span>
                </div>
            </div>
        `).join('');

            $('#cart-items').html(cartItemsHtml);
        }

        function updateProductButton(productId, quantity) {
            const controlsHtml = `
            <div class="flex items-center justify-between bg-gray-50 rounded-xl p-2">
                <button onclick="updateCartQuantity(${productId}, ${quantity - 1})" class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-red-500 text-white hover:bg-red-600 flex items-center justify-center">
                    <i class="fas fa-minus text-xs md:text-sm"></i>
                </button>
                <div class="text-center">
                    <span class="text-lg md:text-2xl font-bold text-gray-900">${quantity}</span>
                    <p class="text-xs text-gray-500">di keranjang</p>
                </div>
                <button onclick="updateCartQuantity(${productId}, ${quantity + 1})" class="w-8 h-8 md:w-10 md:h-10 rounded-xl flex items-center justify-center bg-green-500 text-white hover:bg-green-600">
                    <i class="fas fa-plus text-xs md:text-sm"></i>
                </button>
            </div>
        `;
            $(`.cart-controls-${productId}`).html(controlsHtml);
        }

        function resetProductButton(productId) {
            const product = $(`.product-card[data-id="${productId}"]`);

            const controlsHtml = `
                <button onclick="addToCart(${productId}, '${product.data('name')}', ${product.find('.text-green-600').text().replace(/[^\d]/g, '')})" class="add-btn-${productId} w-full py-2 md:py-3 rounded-xl font-bold text-sm md:text-base transition-all duration-200 bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 shadow-lg">
                    ➕ Tambah
                </button>
            `;
            $(`.cart-controls-${productId}`).html(controlsHtml);
        }


        // Transaction processing
        function processTransaction() {
            if (cart.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }

            $('#loading-overlay').show();

            // Prepare transaction data
            const transactionData = {
                items: cart.map(item => ({
                    product_id: item.id,
                    quantity: item.quantity,
                    price: item.price
                })),
                total: getTotalPrice(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            // Send to server
            $.ajax({
                url: '{{ route('dashboard.kasir.store') }}',
                method: 'POST',
                data: transactionData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#loading-overlay').hide();
                    if (response.success) {
                        $('#transaction-id').text(response.transaction_id);
                        $('#success-modal').show();
                        clearCart();

                    } else {
                        alert('Gagal memproses transaksi: ' + response.message);
                    }
                },
                error: function(xhr) {
                    $('#loading-overlay').hide();
                    alert('Terjadi kesalahan saat memproses transaksi');
                    console.error(xhr.responseText);
                }
            });
        }

        function closeSuccessModal() {
            $('#success-modal').hide();
        }

        // Event handlers
        $(document).ready(function() {
            // Mobile menu toggle
            $('#mobile-menu-btn').click(function() {
                $('#sidebar').toggleClass('open');
            });

            // Payment method selection
            $('.payment-method').click(function() {
                $('.payment-method').removeClass('active border-green-500 bg-green-50 text-green-700')
                    .addClass('border-gray-300 bg-white text-gray-700');
                $(this).removeClass('border-gray-300 bg-white text-gray-700').addClass(
                    'active border-green-500 bg-green-50 text-green-700');
                selectedPaymentMethod = $(this).data('method');
            });

            // Process transaction
            $('#process-transaction').click(processTransaction);

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

            // Initialize cart display
            updateCartDisplay();
        });

        // Global functions for onclick handlers
        window.addToCart = addToCart;
        window.updateCartQuantity = updateCartQuantity;
        window.removeFromCart = removeFromCart;
        window.processTransaction = processTransaction;
        window.printReceipt = printReceipt;
        window.closeSuccessModal = closeSuccessModal;
    </script>
@endsection
