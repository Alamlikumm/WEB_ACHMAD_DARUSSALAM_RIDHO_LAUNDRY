@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    {{-- Card: Total Pelanggan --}}
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $totalCustomer }}</div>
            <div class="stat-label">Total Pelanggan</div>
        </div>
    </div>
    {{-- Card: Total Order --}}
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(14, 165, 233, 0.15); color: #38bdf8;">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-value">{{ $totalOrder }}</div>
            <div class="stat-label">Total Orderan</div>
        </div>
    </div>
    {{-- Card: Order Baru --}}
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $orderBaru }}</div>
            <div class="stat-label">Order Dalam Proses</div>
        </div>
    </div>
    {{-- Card: Order Selesai --}}
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.15); color: #4ade80;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $orderSelesai }}</div>
            <div class="stat-label">Order Selesai</div>
        </div>
    </div>
</div>

{{-- Info Cards --}}
<div class="row g-4">
    <div class="col-md-6">
        <div class="content-card">
            <h5 style="margin-bottom: 16px;"><i class="fas fa-concierge-bell" style="color: var(--accent);"></i> &nbsp;Layanan Tersedia</h5>
            <div class="stat-value">{{ $totalService }}</div>
            <div class="stat-label">Jenis Layanan Aktif</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-card">
            <h5 style="margin-bottom: 16px;"><i class="fas fa-user-shield" style="color: var(--accent);"></i> &nbsp;Pengguna Sistem</h5>
            <div class="stat-value">{{ $totalUser }}</div>
            <div class="stat-label">Total Pengguna Terdaftar</div>
        </div>
    </div>
</div>
@endsection
