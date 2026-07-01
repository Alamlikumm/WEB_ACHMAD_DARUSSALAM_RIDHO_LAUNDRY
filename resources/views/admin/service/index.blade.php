@extends('layouts.app')
@section('title', 'Jenis Layanan')

@section('content')
    <div class="content-card">
        <div class="card-header-custom">
            <h5><i class="fas fa-concierge-bell" style="color: var(--accent);"></i> &nbsp;Daftar Layanan</h5>
            <a href="{{ route('admin.service.create') }}" class="btn-accent">
                <i class="fas fa-plus"></i> Tambah Layanan
            </a>
        </div>

        <div class="table-responsive">
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Layanan</th>
                        <th>Harga (per kg)</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $i => $s)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $s->service_name }}</td>
                            <td>Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                            <td>{{ $s->description }}</td>
                            <td>
                                <a href="{{ route('admin.service.edit', $s->id) }}"
                                    class="btn-accent btn-sm-custom btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-service-{{ $s->id }}"
                                    action="{{ route('admin.service.destroy', $s->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-service-{{ $s->id }}')"
                                        class="btn-accent btn-sm-custom btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color: var(--text-secondary);">Belum ada data
                                layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
