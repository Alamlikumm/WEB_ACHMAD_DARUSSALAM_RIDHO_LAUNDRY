<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TransOrder;
use App\Models\TypeOfService;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalCustomer'  => Customer::count(),
            'totalOrder'     => TransOrder::count(),
            'totalService'   => TypeOfService::count(),
            'totalUser'      => User::count(),
            'orderBaru'      => TransOrder::where('order_status', 0)->count(),
            'orderSelesai'   => TransOrder::where('order_status', 1)->count(),
        ];

        return view('dashboard', $data);
    }
}
