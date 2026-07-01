@extends('layouts.app')
@section('title', 'Edit Layanan')

@section('content')
<div class="content-card" style="max-width: 600px;">
    <h5 style="margin-bottom: 24px;"><i class="fas fa-edit" style="color: var(--accent);"></i> &nbsp;Form Edit Layanan</h5>

    <form action="{{ route('admin.service.update', $service->id) }}" method="POST">
        @csrf @method('PUT')
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Nama Layanan</label>
            <input type="text" name="service_name" class="form-control-dark" value="{{ old('service_name', $service->service_name) }}" required>
        </div>
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Harga (per kg)</label>
            <input type="number" name="price" class="form-control-dark" value="{{ old('price', $service->price) }}" required>
        </div>
        <div style="margin-bottom: 24px;">
            <label class="form-label-dark">Deskripsi</label>
            <textarea name="description" class="form-control-dark" rows="3">{{ old('description', $service->description) }}</textarea>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-accent"><i class="fas fa-save"></i> Update</button>
            <a href="{{ route('admin.service.index') }}" class="btn-accent" style="background: #475569;">Batal</a>
        </div>
    </form>
</div>
@endsection
