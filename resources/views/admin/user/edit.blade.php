@extends('layouts.app')
@section('title', 'Edit Pengguna')

@section('content')
<div class="content-card" style="max-width: 600px;">
    <h5 style="margin-bottom: 24px;"><i class="fas fa-user-edit" style="color: var(--accent);"></i> &nbsp;Form Edit Pengguna</h5>

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf @method('PUT')
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Nama</label>
            <input type="text" name="name" class="form-control-dark" value="{{ old('name', $user->name) }}" required>
        </div>
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Email</label>
            <input type="email" name="email" class="form-control-dark" value="{{ old('email', $user->email) }}" required>
            @error('email') <small style="color: var(--danger);">{{ $message }}</small> @enderror
        </div>
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Password <small style="color: var(--text-secondary);">(Kosongkan jika tidak diubah)</small></label>
            <input type="password" name="password" class="form-control-dark">
        </div>
        <div style="margin-bottom: 24px;">
            <label class="form-label-dark">Level</label>
            <select name="id_level" class="form-control-dark" required>
                @foreach($levels as $level)
                    <option value="{{ $level->id }}" {{ $user->id_level == $level->id ? 'selected' : '' }}>{{ $level->level_name }}</option>
                @endforeach
            </select>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-accent"><i class="fas fa-save"></i> Update</button>
            <a href="{{ route('admin.user.index') }}" class="btn-accent" style="background: #475569;">Batal</a>
        </div>
    </form>
</div>
@endsection
