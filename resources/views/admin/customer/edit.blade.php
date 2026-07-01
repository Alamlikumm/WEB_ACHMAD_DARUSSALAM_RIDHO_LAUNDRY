@extends('layouts.app')
@section('title', 'Edit Pelanggan')

@section('content')
<div class="content-card" style="max-width: 600px;">
    <h5 style="margin-bottom: 24px;"><i class="fas fa-user-edit" style="color: var(--accent);"></i> &nbsp;Form Edit Pelanggan</h5>

    <form action="{{ route('admin.customer.update', $customer->id) }}" method="POST">
        @csrf @method('PUT')
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">Nama Pelanggan</label>
            <input type="text" name="customer_name" class="form-control-dark" value="{{ old('customer_name', $customer->customer_name) }}" required>
        </div>
        <div style="margin-bottom: 16px;">
            <label class="form-label-dark">No. Telepon</label>
            <input type="text" name="phone" class="form-control-dark" value="{{ old('phone', $customer->phone) }}" required>
        </div>
        <div style="margin-bottom: 24px;">
            <label class="form-label-dark">Alamat</label>
            <textarea name="address" class="form-control-dark" rows="3" required>{{ old('address', $customer->address) }}</textarea>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-accent"><i class="fas fa-save"></i> Update</button>
            <a href="{{ route('admin.customer.index') }}" class="btn-accent" style="background: #475569;">Batal</a>
        </div>
    </form>
</div>
@endsection
