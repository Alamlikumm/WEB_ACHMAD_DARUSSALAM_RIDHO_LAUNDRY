<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('level')->latest()->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('admin.user.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'id_level' => 'required',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'id_level' => $request->id_level,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $levels = Level::all();
        return view('admin.user.edit', compact('user', 'levels'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:user,email,' . $user->id,
            'id_level' => 'required',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'id_level' => $request->id_level,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
