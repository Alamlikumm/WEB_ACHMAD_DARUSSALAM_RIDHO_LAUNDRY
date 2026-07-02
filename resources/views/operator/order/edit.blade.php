@extends('layouts.app')
@section('title', 'Edit Transaksi')

@section('content')
    <form action="{{ route('operator.order.update', $order->id) }}" method="POST" id="orderForm">
        @csrf
        @method('PUT')

        {{-- Info Order --}}
        <div class="content-card" style="margin-bottom: 20px;">
            <h5 style="margin-bottom: 20px;"><i class="fas fa-file-invoice" style="color: var(--accent);"></i> &nbsp;Edit Informasi
                Order</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label-dark">Pelanggan</label>
                    <select name="id_customer" class="form-control-dark" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($customers as $c)
                            <option value="{{ $c->id }}" {{ $order->id_customer == $c->id ? 'selected' : '' }}>{{ $c->customer_name }} - {{ $c->phone }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label-dark">Tanggal Order</label>
                    <input type="date" name="order_date" class="form-control-dark" value="{{ $order->order_date }}" min="{{ date('Y-m-d', strtotime($order->order_date)) }}" id="orderDateInput" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label-dark">Estimasi Selesai</label>
                    <input type="date" name="order_end_date" class="form-control-dark" value="{{ $order->order_end_date }}" min="{{ date('Y-m-d', strtotime($order->order_date)) }}" id="orderEndDateInput">
                </div>
            </div>
        </div>

        {{-- Detail Jasa --}}
        <div class="content-card" style="margin-bottom: 20px;">
            <div class="card-header-custom">
                <h5><i class="fas fa-list" style="color: var(--accent);"></i> &nbsp;Detail Layanan</h5>
                <button type="button" onclick="addService()" class="btn-accent btn-sm-custom btn-success-custom">
                    <i class="fas fa-plus"></i> Tambah Layanan
                </button>
            </div>

            <div class="table-responsive">
                <table class="table-dark-custom" id="serviceTable">
                    <thead>
                        <tr>
                            <th>Jasa Layanan</th>
                            <th style="width:100px;">Qty (kg)</th>
                            <th style="width:150px;">Harga</th>
                            <th style="width:150px;">Subtotal</th>
                            <th>Catatan</th>
                            <th style="width:60px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="serviceBody">
                        @foreach ($order->details as $index => $detail)
                        <tr id="row-{{ $index }}">
                            <td>
                                <select name="services[{{ $index }}][id_service]" class="form-control-dark service-select"
                                    data-row="{{ $index }}" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($services as $s)
                                        <option value="{{ $s->id }}" data-price="{{ $s->price }}" {{ $s->id == $detail->id_service ? 'selected' : '' }}>
                                            {{ $s->service_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="services[{{ $index }}][qty]" class="form-control-dark qty-input"
                                    data-row="{{ $index }}" min="1" value="{{ $detail->qty }}" required></td>
                            <td><span class="price-display" id="price-{{ $index }}">Rp {{ number_format($detail->service->price, 0, ',', '.') }}</span></td>
                            <td><span class="subtotal-display" id="subtotal-{{ $index }}">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span></td>
                            <td><input type="text" name="services[{{ $index }}][notes]" class="form-control-dark"
                                    placeholder="Catatan..." value="{{ $detail->notes }}"></td>
                            <td>
                                @if ($index > 0)
                                <button type="button" onclick="removeService({{ $index }})" class="btn-accent btn-sm-custom btn-delete">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pembayaran --}}
        <div class="content-card">
            <h5 style="margin-bottom: 20px;"><i class="fas fa-money-bill-wave" style="color: var(--accent);"></i>
                &nbsp;Pembayaran</h5>
            <div class="row g-3 align-items-end mb-4">
                <div class="col-md-3">
                    <label class="form-label-dark">Subtotal</label>
                    <div style="font-size: 20px; font-weight: 600; color: #ffffff;" id="orderSubtotal">Rp {{ number_format($order->total - $order->tax, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label-dark">Tax (%)</label>
                    <input type="number" name="tax_rate" class="form-control-dark" id="taxRate" oninput="calcGrandTotal()"
                        value="{{ $order->tax_rate }}" min="0" max="100" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label-dark">Tax (Amount)</label>
                    <div style="font-size: 20px; font-weight: 600; color: #fbbf24;" id="orderTax">Rp {{ number_format($order->tax, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label-dark">Total Akhir</label>
                    <div style="font-size: 24px; font-weight: 700; color: #198754;" id="grandTotal">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    <input type="hidden" name="grand_total" id="grandTotalInput" value="{{ $order->total }}">
                </div>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label-dark">Bayar</label>
                    <input type="number" name="order_pay" class="form-control-dark" id="orderPay" oninput="calcChange()"
                        value="{{ $order->order_pay }}" placeholder="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label-dark">Kembalian</label>
                    <div style="font-size: 22px; font-weight: 600; color: #fbbf24;" id="orderChange">Rp {{ number_format($order->order_change, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn-accent" style="width: 100%; padding: 14px; font-size: 15px;">
                        <i class="fas fa-save"></i> Perbarui Transaksi
                    </button>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            let rowIndex = {{ count($order->details) }};
            const servicesData = @json($services);

            function addService() {
                let options = '<option value="">-- Pilih --</option>';
                servicesData.forEach(s => {
                    options += `<option value="${s.id}" data-price="${s.price}">${s.service_name}</option>`;
                });

                const row = `
        <tr id="row-${rowIndex}">
            <td>
                <select name="services[${rowIndex}][id_service]" class="form-control-dark service-select" data-row="${rowIndex}" required>
                    ${options}
                </select>
            </td>
            <td><input type="number" name="services[${rowIndex}][qty]" class="form-control-dark qty-input" data-row="${rowIndex}" min="1" value="1" required></td>
            <td><span class="price-display" id="price-${rowIndex}">Rp 0</span></td>
            <td><span class="subtotal-display" id="subtotal-${rowIndex}">Rp 0</span></td>
            <td><input type="text" name="services[${rowIndex}][notes]" class="form-control-dark" placeholder="Catatan..."></td>
            <td>
                <button type="button" onclick="removeService(${rowIndex})" class="btn-accent btn-sm-custom btn-delete">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>`;

                document.getElementById('serviceBody').insertAdjacentHTML('beforeend', row);
                rowIndex++;
            }

            function removeService(index) {
                document.getElementById('row-' + index).remove();
                calcGrandTotal();
            }

            // Event delegation untuk select dan qty
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('service-select')) {
                    calcRow(e.target.dataset.row);
                }
            });
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('qty-input')) {
                    calcRow(e.target.dataset.row);
                }
            });

            function calcRow(row) {
                const select = document.querySelector(`select[data-row="${row}"]`);
                const qtyInput = document.querySelector(`input.qty-input[data-row="${row}"]`);
                const option = select.options[select.selectedIndex];
                const price = parseInt(option.getAttribute('data-price')) || 0;
                const qty = parseInt(qtyInput.value) || 0;
                const subtotal = price * qty;

                document.getElementById('price-' + row).textContent = 'Rp ' + price.toLocaleString('id-ID');
                document.getElementById('subtotal-' + row).textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                calcGrandTotal();
            }

            function calcGrandTotal() {
                let subtotal = 0;
                document.querySelectorAll('.subtotal-display').forEach(el => {
                    const val = el.textContent.replace(/[^0-9]/g, '');
                    subtotal += parseInt(val) || 0;
                });
                
                const taxRateInput = document.getElementById('taxRate');
                const taxRate = parseFloat(taxRateInput.value) || 0;
                const taxAmount = Math.round(subtotal * (taxRate / 100));
                const total = subtotal + taxAmount;

                document.getElementById('orderSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                document.getElementById('orderTax').textContent = 'Rp ' + taxAmount.toLocaleString('id-ID');
                document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('grandTotalInput').value = total;
                calcChange();
            }

            function calcChange() {
                const total = parseInt(document.getElementById('grandTotalInput').value) || 0;
                const pay = parseInt(document.getElementById('orderPay').value) || 0;
                const change = pay - total;
                document.getElementById('orderChange').textContent = 'Rp ' + (change > 0 ? change : 0).toLocaleString('id-ID');
            }

            // Prevent selecting a completed date before the start date
            document.getElementById('orderDateInput').addEventListener('change', function() {
                const endDateInput = document.getElementById('orderEndDateInput');
                endDateInput.min = this.value;
                if (endDateInput.value && endDateInput.value < this.value) {
                    endDateInput.value = this.value;
                }
            });
        </script>
    @endpush
@endsection
