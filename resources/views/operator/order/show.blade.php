@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
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
                        <td style="padding: 8px 0;">{{ $order->customer->customer_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-secondary);">Telepon</td>
                        <td style="padding: 8px 0;">{{ $order->customer->phone }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-secondary);">Tanggal Order</td>
                        <td style="padding: 8px 0;">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
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
                        <td style="padding: 6px 0; color: var(--text-secondary);">Total</td>
                        <td style="padding: 6px 0; font-weight: 700; font-size: 20px; color: #4ade80;">Rp
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

    @push('styles')
        <style>
            @media print {

                .sidebar,
                .topbar,
                .no-print {
                    display: none !important;
                }

                .main-content {
                    margin: 0 !important;
                    padding: 10px !important;
                }

                .content-card {
                    box-shadow: none !important;
                    border: 1px solid #ccc !important;
                    background: white !important;
                    color: black !important;
                    margin-bottom: 20px;
                }

                body {
                    background: white !important;
                    color: black !important;
                }

                .table-dark-custom {
                    color: black !important;
                }

                h5,
                td,
                span {
                    color: black !important;
                }

                .badge-status {
                    border: 1px solid black;
                }
            }
        </style>
    @endpush
@endsection
