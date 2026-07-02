<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use App\Models\TypeOfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = TransOrder::with(['customer', 'details.service'])->latest()->get();
        return view('operator.order.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $services  = TypeOfService::all();
        return view('operator.order.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_customer'   => 'required',
            'order_date'    => 'required|date',
            'order_end_date'=> 'nullable|date',
            'services'      => 'required|array|min:1',
            'services.*.id_service' => 'required',
            'services.*.qty'        => 'required|numeric|min:1',
            'order_pay'     => 'nullable|numeric',
            'tax_rate'      => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            // Hitung subtotal
            $subtotal = 0;
            foreach ($request->services as $item) {
                $service = TypeOfService::find($item['id_service']);
                $subtotal += $service->price * $item['qty'];
            }

            // Hitung tax dan grand total
            $taxRate = floatval($request->tax_rate);
            $tax = round($subtotal * ($taxRate / 100));
            $total = $subtotal + $tax;

            // Hitung kembalian
            $orderPay = $request->order_pay ?? 0;
            $orderChange = $orderPay > 0 ? $orderPay - $total : 0;

            // Generate kode order: ORD-YYYYMMDD-XXXX
            $orderCode = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

            // Simpan order
            $order = TransOrder::create([
                'id_customer'    => $request->id_customer,
                'order_code'     => $orderCode,
                'order_date'     => $request->order_date,
                'order_end_date' => $request->order_end_date,
                'order_status'   => 0, // Baru
                'order_pay'      => $orderPay,
                'order_change'   => $orderChange,
                'total'          => $total,
                'tax'            => $tax,
                'tax_rate'       => $taxRate,
            ]);

            // Simpan detail order
            foreach ($request->services as $item) {
                $service = TypeOfService::find($item['id_service']);
                $itemSubtotal = $service->price * $item['qty'];

                TransOrderDetail::create([
                    'id_order'   => $order->id,
                    'id_service' => $item['id_service'],
                    'qty'        => $item['qty'],
                    'subtotal'   => $itemSubtotal,
                    'notes'      => $item['notes'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('operator.order.index')->with('success', 'Transaksi berhasil dibuat! Kode: ' . $orderCode);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    public function show(TransOrder $order)
    {
        $order->load(['customer', 'details.service']);
        return view('operator.order.show', compact('order'));
    }

    public function invoice(TransOrder $order)
    {
        $order->load(['customer', 'details.service', 'pickup']);
        return view('operator.order.invoice', compact('order'));
    }

    public function edit(TransOrder $order)
    {
        $order->load(['customer', 'details.service']);
        $customers = Customer::all();
        $services  = TypeOfService::all();
        return view('operator.order.edit', compact('order', 'customers', 'services'));
    }

    public function update(Request $request, TransOrder $order)
    {
        $request->validate([
            'id_customer'   => 'required',
            'order_date'    => 'required|date',
            'order_end_date'=> 'nullable|date',
            'services'      => 'required|array|min:1',
            'services.*.id_service' => 'required',
            'services.*.qty'        => 'required|numeric|min:1',
            'order_pay'     => 'nullable|numeric',
            'tax_rate'      => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            // Hitung subtotal
            $subtotal = 0;
            foreach ($request->services as $item) {
                $service = TypeOfService::find($item['id_service']);
                $subtotal += $service->price * $item['qty'];
            }

            // Hitung tax dan grand total
            $taxRate = floatval($request->tax_rate);
            $tax = round($subtotal * ($taxRate / 100));
            $total = $subtotal + $tax;

            // Hitung kembalian
            $orderPay = $request->order_pay ?? 0;
            $orderChange = $orderPay > 0 ? $orderPay - $total : 0;

            // Update order
            $order->update([
                'id_customer'    => $request->id_customer,
                'order_date'     => $request->order_date,
                'order_end_date' => $request->order_end_date,
                'order_pay'      => $orderPay,
                'order_change'   => $orderChange,
                'total'          => $total,
                'tax'            => $tax,
                'tax_rate'       => $taxRate,
            ]);

            // Hapus detail lama dan simpan yang baru
            $order->details()->delete();
            foreach ($request->services as $item) {
                $service = TypeOfService::find($item['id_service']);
                $itemSubtotal = $service->price * $item['qty'];

                TransOrderDetail::create([
                    'id_order'   => $order->id,
                    'id_service' => $item['id_service'],
                    'qty'        => $item['qty'],
                    'subtotal'   => $itemSubtotal,
                    'notes'      => $item['notes'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('operator.order.index')->with('success', 'Transaksi berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }

    public function destroy(TransOrder $order)
    {
        DB::beginTransaction();
        try {
            $order->details()->delete();
            $order->pickup()->delete();
            $order->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
