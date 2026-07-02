@extends('layouts.app')
@section('title', 'Laporan Penjualan')

@section('content')
    {{-- Header Laporan saat dicetak --}}
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

    <div class="content-card mb-4 no-print">
        <h5 style="margin-bottom: 20px;"><i class="fas fa-filter" style="color: var(--accent);"></i> &nbsp;Filter Laporan</h5>

        <form action="{{ route('pimpinan.report.index') }}" method="GET">
            <div class="row align-items-end g-3">
                <div class="col-md-4">
                    <label class="form-label-dark">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control-dark" value="{{ $startDate }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label-dark">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control-dark" value="{{ $endDate }}" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn-accent" style="width: 100%; padding: 10px;">
                        <i class="fas fa-search"></i> Tampilkan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="content-card">
        <div class="card-header-custom" style="display: flex; justify-content: space-between; align-items: center;">
            <h5><i class="fas fa-chart-bar" style="color: var(--accent);"></i> &nbsp;Data Laporan Penjualan</h5>

            <div style="text-align: right; display: flex; align-items: center; gap: 20px;">
                <button type="button" onclick="window.print()" class="btn-accent no-print"
                    style="background: #10b981; padding: 6px 12px;">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
                <div>
                    <span style="font-size: 13px; color: var(--text-secondary);">Total Pendapatan:</span><br>
                    <strong style="font-size: 20px; color: #4ade80;">Rp
                        {{ number_format($totalPendapatan, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Order</th>
                        <th>Pelanggan</th>
                        <th>Tgl Order</th>
                        <th>Status</th>
                        <th style="text-align: right;">Total Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $i => $o)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $o->order_code }}</strong></td>
                            <td>{{ $o->customer?->customer_name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($o->order_date)->format('d/m/Y') }}</td>
                            <td>
                                @if ($o->order_status == 0)
                                    <span class="badge-status badge-baru">Proses</span>
                                @else
                                    <span class="badge-status badge-selesai">Selesai</span>
                                @endif
                            </td>
                            <td style="text-align: right;">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color: var(--text-secondary);">
                                Belum ada data transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('styles')
        <style>
            @media print {

                .sidebar,
                .topbar,
                form,
                .no-print {
                    display: none !important;
                }

                .main-content {
                    margin: 0 !important;
                    padding: 10px !important;
                }

                .content-card {
                    box-shadow: none !important;
                    border: none !important;
                    background: white !important;
                    color: black !important;
                }

                body {
                    background: white !important;
                    color: black !important;
                }

                .table-dark-custom {
                    color: black !important;
                    border-collapse: collapse;
                }

                .table-dark-custom th,
                .table-dark-custom td {
                    border: 1px solid #ccc;
                    padding: 8px;
                }

                h5,
                td,
                span,
                strong {
                    color: black !important;
                }

                .badge-status {
                    border: 1px solid black;
                }
            }
        </style>
    @endpush
@endsection
