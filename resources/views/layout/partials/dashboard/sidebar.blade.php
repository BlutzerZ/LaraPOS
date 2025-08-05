<div id="sidebar"
    class="sidebar fixed left-0 top-0 h-full w-64 bg-white shadow-2xl border-r z-40 transition-transform duration-300">
    <div class="p-6 border-b">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            Dashboard Admin
        </h2>
    </div>

    <nav class="p-4 space-y-2">
        <a href="{{ route('dashboard.kasir.index') }}"
            class="sidebar-item
            {{ Request::routeIs('dashboard.kasir.index') ? 'active' : 'text-gray-600 hover:bg-gray-100' }}
            flex items-center px-4 py-3 rounded-xl transition-all duration-200">
            <i class="fas fa-cash-register mr-3"></i>
            <span class="font-medium">Kasir</span>
        </a>
        <a href="{{ route('dashboard.barang.index') }}"
            class="sidebar-item
            {{ Request::routeIs('dashboard.barang.index') ? 'active' : 'text-gray-600 hover:bg-gray-100' }}
            flex items-center px-4 py-3 rounded-xl transition-all duration-200">
            <i class="fas fa-box mr-3"></i>
            <span class="font-medium">Kelola Barang</span>
        </a>
        <a href="{{ route('dashboard.transaksi.index') }}"
            class="sidebar-item
            {{ Request::routeIs('dashboard.transaksi.index') ? 'active' : 'text-gray-600 hover:bg-gray-100' }}
            flex items-center px-4 py-3 rounded-xl transition-all duration-200">
            <i class="fas fa-receipt mr-3"></i>
            <span class="font-medium">Kelola Transaksi</span>
        </a>
    </nav>
</div>
