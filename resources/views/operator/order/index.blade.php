@extends('layouts.app')
@section('title', 'Daftar Transaksi')

@section('content')
    <div class="content-card">
        <div class="card-header-custom">
            <h5><i class="fas fa-cash-register" style="color: var(--accent);"></i> &nbsp;Daftar Transaksi</h5>
            <a href="{{ route('operator.order.create') }}" class="btn-accent">
                <i class="fas fa-plus"></i> Transaksi Baru
            </a>
        </div>

        <div class="table-responsive">
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Order</th>
                        <th>Pelanggan</th>
                        <th>Tgl Order</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $i => $o)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $o->order_code }}</strong></td>
                            <td>{{ $o->customer->customer_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($o->order_date)->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                            <td>
                                @if ($o->order_status == 0)
                                    <span class="badge-status badge-baru">Proses</span>
                                @else
                                    <span class="badge-status badge-selesai">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('operator.order.show', $o->id) }}" class="btn-accent btn-sm-custom">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; color: var(--text-secondary);">Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
