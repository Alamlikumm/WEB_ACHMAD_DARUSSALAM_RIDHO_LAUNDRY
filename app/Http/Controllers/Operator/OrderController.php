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
        ]);

        DB::beginTransaction();
        try {
            // Hitung total
            $total = 0;
            foreach ($request->services as $item) {
                $service = TypeOfService::find($item['id_service']);
                $subtotal = $service->price * $item['qty'];
                $total += $subtotal;
            }

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
            ]);

            // Simpan detail order
            foreach ($request->services as $item) {
                $service = TypeOfService::find($item['id_service']);
                $subtotal = $service->price * $item['qty'];

                TransOrderDetail::create([
                    'id_order'   => $order->id,
                    'id_service' => $item['id_service'],
                    'qty'        => $item['qty'],
                    'subtotal'   => $subtotal,
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
}
