@extends('layouts.app')
@section('title', 'Tambah Pelanggan')

@section('content')
<div class="content-card" style="max-width: 600px;">
    <h5 style="margin-bottom: 24px;"><i class="fas fa-user-plus" style="color: var(--accent);"></i> &nbsp;Form Tambah Pelanggan</h5>

    <form action="{{ route('admin.customer.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Nama Pelanggan</label>
            <input type="text" name="customer_name" class="form-control-dark" value="{{ old('customer_name') }}" required>
            @error('customer_name') <small style="color: var(--danger);">{{ $message }}</small> @enderror
        </div>
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">No. Telepon</label>
            <input type="text" name="phone" class="form-control-dark" value="{{ old('phone') }}" required>
            @error('phone') <small style="color: var(--danger);">{{ $message }}</small> @enderror
        </div>
        <div style="margin-bottom: 24px;">
            <label class="form-label-dark">Alamat</label>
            <textarea name="address" class="form-control-dark" rows="3" required>{{ old('address') }}</textarea>
            @error('address') <small style="color: var(--danger);">{{ $message }}</small> @enderror
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-accent"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.customer.index') }}" class="btn-accent" style="background: #475569;">Batal</a>
        </div>
    </form>
</div>
@endsection
