@extends('layouts.app')
@section('title', 'Data Pengguna')

@section('content')
    <div class="content-card">
        <div class="card-header-custom">
            <h5><i class="fas fa-user-shield" style="color: var(--accent);"></i> &nbsp;Daftar Pengguna</h5>
            <a href="{{ route('admin.user.create') }}" class="btn-accent">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </a>
        </div>

        <div class="table-responsive">
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $u)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td><span class="badge-status badge-selesai">{{ $u->level->level_name }}</span></td>
                            <td>
                                <a href="{{ route('admin.user.edit', $u->id) }}" class="btn-accent btn-sm-custom btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if ($u->id != auth()->id())
                                    <form id="delete-user-{{ $u->id }}"
                                        action="{{ route('admin.user.destroy', $u->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete('delete-user-{{ $u->id }}')"
                                            class="btn-accent btn-sm-custom btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color: var(--text-secondary);">Belum ada data
                                pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
