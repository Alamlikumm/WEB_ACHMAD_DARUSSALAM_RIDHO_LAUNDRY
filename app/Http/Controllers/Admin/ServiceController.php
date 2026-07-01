<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeOfService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = TypeOfService::latest()->get();
        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|max:50',
            'price'        => 'required|numeric',
            'description'  => 'nullable',
        ]);

        TypeOfService::create($request->all());
        return redirect()->route('admin.service.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(TypeOfService $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, TypeOfService $service)
    {
        $request->validate([
            'service_name' => 'required|max:50',
            'price'        => 'required|numeric',
            'description'  => 'nullable',
        ]);

        $service->update($request->all());
        return redirect()->route('admin.service.index')->with('success', 'Layanan berhasil diupdate.');
    }

    public function destroy(TypeOfService $service)
    {
        $service->delete();
        return redirect()->route('admin.service.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
