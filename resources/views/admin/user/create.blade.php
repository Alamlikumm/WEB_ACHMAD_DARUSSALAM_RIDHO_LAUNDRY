@extends('layouts.app')
@section('title', 'Tambah Pengguna')

@section('content')
<div class="content-card" style="max-width: 600px;">
    <h5 style="margin-bottom: 24px;"><i class="fas fa-user-plus" style="color: var(--accent);"></i> &nbsp;Form Tambah Pengguna</h5>

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Nama</label>
            <input type="text" name="name" class="form-control-dark" value="{{ old('name') }}" required>
        </div>
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Email</label>
            <input type="email" name="email" class="form-control-dark" value="{{ old('email') }}" required>
            @error('email') <small style="color: var(--danger);">{{ $message }}</small> @enderror
        </div>
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Password</label>
            <input type="password" name="password" class="form-control-dark" required>
        </div>
        <div style="margin-bottom: 24px;">
            <label class="form-label-dark">Level</label>
            <select name="id_level" class="form-control-dark" required>
                <option value="">-- Pilih Level --</option>
                @foreach($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                @endforeach
            </select>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-accent"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.user.index') }}" class="btn-accent" style="background: #475569;">Batal</a>
        </div>
    </form>
</div>
@endsection
