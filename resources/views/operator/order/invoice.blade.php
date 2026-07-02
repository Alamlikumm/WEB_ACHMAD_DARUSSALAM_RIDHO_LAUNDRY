@extends('layouts.app')
@section('title', 'Invoice Pembayaran')

@section('content')
<div class="container py-2 print-container" style="max-width: 900px; margin: 0 auto;">

    {{-- Invoice Action Buttons --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="{{ route('operator.pickup.index') }}" class="btn btn-dark">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Pengambilan
        </a>
        <button type="button" onclick="window.print()" class="btn btn-primary bg-primary text-white" style="border: none;">
            <i class="fas fa-print me-2"></i> Cetak Invoice
        </button>
    </div>

    {{-- Invoice Paper --}}
    <div class="bg-secondary rounded p-4 p-sm-5 invoice-card" style="border: 1px solid #2a2e38;">

        {{-- Header: Logo & Shop Details --}}
        <div class="row align-items-center mb-3 pb-3" style="border-bottom: 2px solid #0e0d0d;">
            <div class="col-6 text-start">
                <img src="{{ asset('darussalam_logo.png') }}" alt="Darussalam Logo" style="height: 110px; border-radius: 4px; object-fit: contain;">
            </div>
            <div class="col-6 text-end">
                <h4 class="mb-1 fw-bold text-dark" style="color: #000000 !important; font-weight: 800;">Darussalam Laundry</h4>
                <p class="mb-0 text-muted" style="font-size: 13px; color: #444444 !important;">Layanan Laundry Bersih, Cepat, dan Wangi</p>
                <p class="mb-0 text-muted" style="font-size: 12px; color: #555555 !important;">Telp: 0812-1007-8290 | Jakarta, Indonesia</p>
            </div>
        </div>

        {{-- Section 1: Order Data (AT THE TOP) --}}
        <div class="mb-4">
            <h5 class="text-primary mb-3"><i class="fas fa-receipt me-2"></i> DATA ORDER</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <table class="table table-borderless text-muted mb-0" style="font-size: 14px;">
                        <tr>
                            <td class="ps-0 py-1" style="width: 140px;">No. Invoice</td>
                            <td class="py-1 text-white">: <strong>{{ $order->order_code }}</strong></td>
                        </tr>
                        <tr>
                            <td class="ps-0 py-1">Nama Pelanggan</td>
                            <td class="py-1 text-white">: {{ $order->customer?->customer_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0 py-1">No. Telepon</td>
                            <td class="py-1 text-white">: {{ $order->customer?->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0 py-1">Alamat Pelanggan</td>
                            <td class="py-1 text-white">: {{ $order->customer?->address ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless text-muted mb-0" style="font-size: 14px;">
                        <tr>
                            <td class="ps-0 py-1" style="width: 140px;">Tgl Masuk</td>
                            <td class="py-1 text-white">: {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0 py-1">Tgl Ambil</td>
                            <td class="py-1 text-white">:
                                {{ $order->pickup ? \Carbon\Carbon::parse($order->pickup->pickup_date)->format('d F Y H:i') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-0 py-1">Status Order</td>
                            <td class="py-1 text-white">:
                                @if ($order->order_status == 0)
                                    <span class="badge bg-warning text-dark">Dalam Proses</span>
                                @else
                                    <span class="badge bg-success">Sudah Diambil</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-0 py-1">Status Pembayaran</td>
                            <td class="py-1 text-white">:
                                @if ($order->order_status == 1 || ($order->order_pay >= $order->total))
                                    <span class="badge bg-success text-white">Lunas</span>
                                @else
                                    <span class="badge bg-danger text-white">Belum Lunas</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Section 2: Detail Layanan (BELOW) --}}
        <div class="mb-4">
            <h5 class="text-primary mb-3"><i class="fas fa-list me-2"></i> DETAIL LAYANAN</h5>
            <div class="table-responsive">
                <table class="table table-dark-custom text-white" style="border: 1px solid #2a2e38;">
                    <thead>
                        <tr style="background-color: #000000;">
                            <th class="py-3 px-3">No</th>
                            <th class="py-3 px-3">Jasa Layanan</th>
                            <th class="py-3 px-3">Harga</th>
                            <th class="py-3 px-3">Jumlah</th>
                            <th class="py-3 px-3">Subtotal</th>
                            <th class="py-3 px-3">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->details as $index => $detail)
                            <tr>
                                <td class="py-3 px-3">{{ $index + 1 }}</td>
                                <td class="py-3 px-3 fw-bold text-white">{{ $detail->service->service_name }}</td>
                                <td class="py-3 px-3">Rp {{ number_format($detail->service->price, 0, ',', '.') }}</td>
                                <td class="py-3 px-3">{{ $detail->qty }} kg</td>
                                <td class="py-3 px-3">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                <td class="py-3 px-3 text-muted">{{ $detail->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section 3: Summary / Calculations --}}
        <div class="row pt-3" style="border-top: 1px dashed #2a2e38;">
            <div class="col-md-6 text-muted mb-3 mb-md-0" style="font-size: 13px;">
                @if($order->pickup && $order->pickup->notes)
                    <p class="mb-1 text-white">Catatan Pengambilan:</p>
                    <p class="mb-0 italic">{{ $order->pickup->notes }}</p>
                @endif
            </div>
            <div class="col-md-6">
                <table class="table table-borderless text-muted mb-0" style="font-size: 14px;">
                    <tr>
                        <td class="ps-0 py-1" style="width: 140px;">Subtotal</td>
                        <td class="py-1 text-end text-white">Rp {{ number_format($order->total - $order->tax, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="ps-0 py-1">Pajak ({{ $order->tax_rate }}%)</td>
                        <td class="py-1 text-end text-warning">Rp {{ number_format($order->tax, 0, ',', '.') }}</td>
                    </tr>
                    <tr style="border-top: 1px solid #2a2e38;">
                        <td class="ps-0 py-2 text-white fw-bold" style="font-size: 16px;">Total Bayar</td>
                        <td class="py-2 text-end text-success fw-bold" style="font-size: 18px;">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-0 py-1">Bayar</td>
                        <td class="py-1 text-end text-white">Rp {{ number_format($order->order_pay, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="ps-0 py-1">Kembalian</td>
                        <td class="py-1 text-end text-info">Rp {{ number_format($order->order_change, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
    @media print {
        @page {
            margin: 5mm 10mm !important;
        }

        /* Hide navbar, sidebar, settings panels and action buttons */
        .sidebar,
        .navbar,
        .no-print,
        .back-to-top,
        #spinner {
            display: none !important;
        }

        /* Adjust content layout for print sheet */
        .content {
            margin: 0 !important;
            padding: 0 !important;
        }

        .print-container {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .invoice-card {
            background-color: transparent !important;
            border: none !important;
            color: #000000 !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        /* Convert text color for readability in print (white paper) */
        h5, h4, td, th, span, strong, p {
            color: #000000 !important;
        }

        .text-white {
            color: #000000 !important;
        }

        .text-muted, .text-sm-muted {
            color: #555555 !important;
        }

        .table-dark-custom {
            border: 1px solid #000000 !important;
        }

        .table-dark-custom thead th {
            background-color: #f2f2f2 !important;
            color: #000000 !important;
            border-bottom: 2px solid #000000 !important;
        }

        .table-dark-custom tbody td {
            background-color: transparent !important;
            color: #000000 !important;
            border-bottom: 1px solid #000000 !important;
        }

        .badge {
            border: 1px solid #000000 !important;
            color: #000000 !important;
            background-color: transparent !important;
        }

        /* Do not stack header columns in print */
        .col-6 {
            width: 50% !important;
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Trigger print automatically when loaded
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            window.print();
        }, 500);
    });
</script>
@endpush
@endsection
