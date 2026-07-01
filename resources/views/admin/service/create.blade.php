@extends('layouts.app')
@section('title', 'Tambah Layanan')

@section('content')
<div class="content-card" style="max-width: 600px;">
    <h5 style="margin-bottom: 24px;"><i class="fas fa-plus-circle" style="color: var(--accent);"></i> &nbsp;Form Tambah Layanan</h5>

    <form action="{{ route('admin.service.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Nama Layanan</label>
            <input type="text" name="service_name" class="form-control-dark" value="{{ old('service_name') }}" required>
        </div>
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Harga (per kg)</label>
            <input type="number" name="price" class="form-control-dark" value="{{ old('price') }}" required>
        </div>
        <div style="margin-bottom: 24px;">
            <label class="form-label-dark">Deskripsi</label>
            <textarea name="description" class="form-control-dark" rows="3">{{ old('description') }}</textarea>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-accent"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.service.index') }}" class="btn-accent" style="background: #475569;">Batal</a>
        </div>
    </form>
</div>
@endsection
