<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="{{ route('dashboard') }}" class="navbar-brand mx-0 mb-3 d-flex justify-content-center px-3">
            <img src="{{ asset('darussalam_logo.png') }}" alt="Logo" style="width: 100%; height: auto; max-height: 120px; border-radius: 4px; object-fit: contain;">
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white bg-dark border border-secondary" style="width: 40px; height: 40px; font-weight: bold; font-size: 14px;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0 text-white">{{ auth()->user()->name }}</h6>
                <span style="font-size: 12px; color: #a3a3a3;">{{ auth()->user()->level->level_name }}</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard') }}" class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            {{-- Admin Menu (Level 1) --}}
            @if (auth()->user()->id_level == 1)
                <div class="px-4 py-2 mt-2 text-muted text-uppercase" style="font-size: 11px; font-weight: bold; letter-spacing: 0.5px;">Master Data</div>
                <a href="{{ route('admin.customer.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.customer.*') ? 'active' : '' }}">
                    <i class="fa fa-users me-2"></i>Data Pelanggan
                </a>
                <a href="{{ route('admin.service.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.service.*') ? 'active' : '' }}">
                    <i class="fa fa-concierge-bell me-2"></i>Jenis Layanan
                </a>
                <a href="{{ route('admin.user.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <i class="fa fa-user-shield me-2"></i>Data Pengguna
                </a>
            @endif

            {{-- Operator Menu (Level 2) --}}
            @if (in_array(auth()->user()->id_level, [1, 2]))
                <div class="px-4 py-2 mt-2 text-muted text-uppercase" style="font-size: 11px; font-weight: bold; letter-spacing: 0.5px;">Transaksi</div>
                <a href="{{ route('operator.order.index') }}" class="nav-item nav-link {{ request()->routeIs('operator.order.*') ? 'active' : '' }}">
                    <i class="fa fa-cash-register me-2"></i>Daftar Transaksi
                </a>
                <a href="{{ route('operator.pickup.index') }}" class="nav-item nav-link {{ request()->routeIs('operator.pickup.*') ? 'active' : '' }}">
                    <i class="fa fa-box-open me-2"></i>Pengambilan
                </a>
            @endif

            {{-- Pimpinan Menu (Level 3) --}}
            @if (in_array(auth()->user()->id_level, [1, 3]))
                <div class="px-4 py-2 mt-2 text-muted text-uppercase" style="font-size: 11px; font-weight: bold; letter-spacing: 0.5px;">Laporan</div>
                <a href="{{ route('pimpinan.report.index') }}" class="nav-item nav-link {{ request()->routeIs('pimpinan.report.*') ? 'active' : '' }}">
                    <i class="fa fa-chart-bar me-2"></i>Laporan Penjualan
                </a>
            @endif

            <div class="px-4 py-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="fa fa-sign-out-alt"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>
<!-- Sidebar End -->
