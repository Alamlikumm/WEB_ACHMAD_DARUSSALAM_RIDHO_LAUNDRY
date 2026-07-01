@extends('layouts.app')
@section('title', 'Data Pelanggan')

@section('content')
    <div class="content-card">
        <div class="card-header-custom">
            <h5><i class="fas fa-users" style="color: var(--accent);"></i> &nbsp;Daftar Pelanggan</h5>
            <a href="{{ route('admin.customer.create') }}" class="btn-accent">
                <i class="fas fa-plus"></i> Tambah Pelanggan
            </a>
        </div>

        <div class="table-responsive">
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $i => $c)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $c->customer_name }}</td>
                            <td>{{ $c->phone }}</td>
                            <td>{{ $c->address }}</td>
                            <td>
                                <a href="{{ route('admin.customer.edit', $c->id) }}"
                                    class="btn-accent btn-sm-custom btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-customer-{{ $c->id }}"
                                    action="{{ route('admin.customer.destroy', $c->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-customer-{{ $c->id }}')"
                                        class="btn-accent btn-sm-custom btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color: var(--text-secondary);">Belum ada data
                                pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
