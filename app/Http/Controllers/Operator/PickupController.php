<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\TransOrder;
use App\Models\TransLaundryPickup;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    public function index()
    {
        // Tampilkan semua order (baru & sudah diambil)
        $orders = TransOrder::with('customer')
            ->latest()
            ->get();
        return view('operator.pickup.index', compact('orders'));
    }

    public function process(Request $request, TransOrder $order)
    {
        if ($order->order_status == 1) {
            return redirect()->back()->with('error', 'Order ini sudah diambil sebelumnya.');
        }

        // Update status order
        $order->update([
            'order_status'   => 1,
            'order_end_date' => now()->toDateString(),
        ]);

        // Buat record pickup
        TransLaundryPickup::create([
            'id_order'    => $order->id,
            'id_customer' => $order->id_customer,
            'pickup_date' => now(),
            'notes'       => $request->notes ?? null,
        ]);

        return redirect()->route('operator.pickup.index')->with('success', 'Order ' . $order->order_code . ' berhasil diproses pengambilan.');
    }
}
