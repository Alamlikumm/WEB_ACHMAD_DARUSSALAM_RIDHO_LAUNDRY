@extends('layouts.app')
@section('title', 'Pengambilan Laundry')

@section('content')
    <div class="content-card">
        <h5 style="margin-bottom: 20px;"><i class="fas fa-box-open" style="color: var(--accent);"></i> &nbsp;Daftar Pengambilan
        </h5>

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
                                    <span class="badge-status badge-baru">Belum Diambil</span>
                                @else
                                    <span class="badge-status badge-selesai">Sudah Diambil</span>
                                @endif
                            </td>
                            <td>
                                @if ($o->order_status == 0)
                                    <button type="button"
                                        onclick="confirmPickup({{ $o->id }}, '{{ $o->order_code }}')"
                                        class="btn-accent btn-sm-custom btn-success-custom">
                                        <i class="fas fa-check"></i> Proses Ambil
                                    </button>

                                    <form id="pickup-form-{{ $o->id }}"
                                        action="{{ route('operator.pickup.process', $o->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        <input type="hidden" name="notes" id="pickup-notes-{{ $o->id }}">
                                    </form>
                                @else
                                    <span style="color: var(--text-secondary); font-size: 13px;">
                                        <i class="fas fa-check-double"></i> Selesai
                                    </span>
                                @endif
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

    @push('scripts')
        <script>
            function confirmPickup(orderId, orderCode) {
                Swal.fire({
                    title: 'Proses Pengambilan?',
                    html: `Order <strong>${orderCode}</strong> akan ditandai sudah diambil.<br><br>
                   <input type="text" id="swal-notes" class="swal2-input" placeholder="Catatan (opsional)" style="background:#0f172a; color:#f1f5f9; border-color:#334155;">`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#475569',
                    confirmButtonText: 'Ya, Proses!',
                    cancelButtonText: 'Batal',
                    background: '#1e293b',
                    color: '#f1f5f9',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const notes = document.getElementById('swal-notes').value;
                        document.getElementById('pickup-notes-' + orderId).value = notes;
                        document.getElementById('pickup-form-' + orderId).submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
