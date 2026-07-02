@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
    {{-- Header Struk saat dicetak --}}
    <div class="row align-items-center mb-4 pb-3 border-bottom border-2 border-dark print-header-logo" style="display: none;">
        <div class="col-6 text-start">
            <img src="{{ asset('darussalam_logo.png') }}" alt="Darussalam Logo" style="height: 90px; border-radius: 4px; object-fit: contain;">
        </div>
        <div class="col-6 text-end">
            <h4 class="mb-1 fw-bold text-dark" style="color: #000000 !important; font-weight: 800;">Darussalam Laundry</h4>
            <p class="mb-0 text-muted" style="font-size: 13px; color: #444444 !important;">Layanan Laundry Bersih, Cepat, dan Wangi</p>
            <p class="mb-0 text-muted" style="font-size: 12px; color: #555555 !important;">Telp: 0812-1007-8290 | Jakarta, Indonesia</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- Info Order --}}
        <div class="col-md-5">
            <div class="content-card">
                <h5 style="margin-bottom: 20px;"><i class="fas fa-receipt" style="color: var(--accent);"></i> &nbsp;Info Order
                </h5>
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-secondary); width: 140px;">Kode Order</td>
                        <td style="padding: 8px 0; font-weight: 600;">{{ $order->order_code }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-secondary);">Pelanggan</td>
                        <td style="padding: 8px 0;">{{ $order->customer?->customer_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-secondary);">Telepon</td>
                        <td style="padding: 8px 0;">{{ $order->customer?->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-secondary);">Tanggal Order</td>
                        <td style="padding: 8px 0;">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-secondary);">Estimasi Selesai</td>
                        <td style="padding: 8px 0;">
                            {{ $order->order_end_date ? \Carbon\Carbon::parse($order->order_end_date)->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-secondary);">Status</td>
                        <td style="padding: 8px 0;">
                            @if ($order->order_status == 0)
                                <span class="badge-status badge-baru">Dalam Proses</span>
                            @else
                                <span class="badge-status badge-selesai">Sudah Diambil</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <hr style="border-color: var(--border-color); margin: 16px 0;">

                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 6px 0; color: var(--text-secondary);">Subtotal</td>
                        <td style="padding: 6px 0; font-weight: 600;">Rp
                            {{ number_format($order->total - $order->tax, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: var(--text-secondary);">Tax ({{ $order->tax_rate }}%)</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #fbbf24;">Rp
                            {{ number_format($order->tax, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: var(--text-secondary);">Total Akhir</td>
                        <td style="padding: 6px 0; font-weight: 700; font-size: 20px; color: #198754;">Rp
                            {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: var(--text-secondary);">Bayar</td>
                        <td style="padding: 6px 0;">Rp {{ number_format($order->order_pay, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: var(--text-secondary);">Kembalian</td>
                        <td style="padding: 6px 0; color: #fbbf24;">Rp
                            {{ number_format($order->order_change, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Detail Layanan --}}
        <div class="col-md-7">
            <div class="content-card">
                <h5 style="margin-bottom: 20px;"><i class="fas fa-list" style="color: var(--accent);"></i> &nbsp;Detail
                    Layanan</h5>
                <table class="table-dark-custom">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Layanan</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->details as $i => $d)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $d->service->service_name }}</td>
                                <td>Rp {{ number_format($d->service->price, 0, ',', '.') }}</td>
                                <td>{{ $d->qty }} kg</td>
                                <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                <td>{{ $d->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 16px;" class="no-print">
                <a href="{{ route('operator.order.index') }}" class="btn-accent" style="background: #475569;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="button" onclick="window.print()" class="btn-accent"
                    style="background: #0ea5e9; margin-left: 10px;">
                    <i class="fas fa-print"></i> Cetak Struk
                </button>
            </div>
        </div>
    </div>


@endsection
