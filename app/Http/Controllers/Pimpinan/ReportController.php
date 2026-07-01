<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\TransOrder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        $query = TransOrder::with('customer')->latest();

        // Filter berdasarkan tanggal jika ada
        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        $orders = $query->get();

        // Hitung total pendapatan dari data yang difilter
        $totalPendapatan = $orders->sum('total');

        return view('pimpinan.report.index', compact('orders', 'startDate', 'endDate', 'totalPendapatan'));
    }
}
