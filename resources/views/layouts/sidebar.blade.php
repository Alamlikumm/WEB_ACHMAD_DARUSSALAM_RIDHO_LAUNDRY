{{-- Sidebar Navigation --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-tshirt"></i>
        </div>
        <div class="sidebar-brand">
            <h2>Darussalam</h2>
            <span>Laundry System</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-section-title">MENU UTAMA</span>
        </div>

        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </a>

        {{-- Admin Menu (Level 1) --}}
        @if (auth()->user()->id_level == 1)
            <div class="nav-section">
                <span class="nav-section-title">MASTER DATA</span>
            </div>
            <a href="{{ route('admin.customer.index') }}"
                class="nav-link {{ request()->routeIs('admin.customer.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Data Pelanggan</span>
            </a>
            <a href="{{ route('admin.service.index') }}"
                class="nav-link {{ request()->routeIs('admin.service.*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell"></i>
                <span>Jenis Layanan</span>
            </a>
            <a href="{{ route('admin.user.index') }}"
                class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i>
                <span>Data Pengguna</span>
            </a>
        @endif

        {{-- Operator Menu (Level 2) --}}
        @if (auth()->user()->id_level == 2)
            <div class="nav-section">
                <span class="nav-section-title">TRANSAKSI</span>
            </div>
            <a href="{{ route('operator.order.index') }}"
                class="nav-link {{ request()->routeIs('operator.order.*') ? 'active' : '' }}">
                <i class="fas fa-cash-register"></i>
                <span>Transaksi Baru</span>
            </a>
            <a href="{{ route('operator.pickup.index') }}"
                class="nav-link {{ request()->routeIs('operator.pickup.*') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i>
                <span>Pengambilan</span>
            </a>
        @endif

        {{-- Pimpinan Menu (Level 3) --}}
        @if (auth()->user()->id_level == 3)
            <div class="nav-section">
                <span class="nav-section-title">LAPORAN</span>
            </div>
            <a href="{{ route('pimpinan.report.index') }}"
                class="nav-link {{ request()->routeIs('pimpinan.report.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan Penjualan</span>
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
