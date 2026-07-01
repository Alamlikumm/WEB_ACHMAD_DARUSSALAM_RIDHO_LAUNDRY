<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|max:50',
            'phone'         => 'required|max:13',
            'address'       => 'required',
        ]);

        Customer::create($request->all());
        return redirect()->route('admin.customer.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'customer_name' => 'required|max:50',
            'phone'         => 'required|max:13',
            'address'       => 'required',
        ]);

        $customer->update($request->all());
        return redirect()->route('admin.customer.index')->with('success', 'Pelanggan berhasil diupdate.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customer.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
