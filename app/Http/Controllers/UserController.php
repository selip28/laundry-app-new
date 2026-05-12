<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cabang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('cabang')->orderBy('role')->orderBy('nama')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $cabangs = Cabang::where('is_active', true)->get();
        return view('users.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'username'  => 'required|string|max:50|unique:users|alpha_dash',
            'password'  => 'required|string|min:6|confirmed',
            'role'      => 'required|in:superadmin,admin_pusat,admin_cabang',
            'cabang_id' => 'required_if:role,admin_cabang|nullable|exists:cabang,id',
        ], [
            'username.unique'       => 'Username sudah digunakan.',
            'username.alpha_dash'   => 'Username hanya boleh huruf, angka, strip, dan underscore.',
            'cabang_id.required_if' => 'Cabang wajib dipilih untuk Admin Cabang.',
        ]);

        User::create([
            'nama'      => $request->nama,
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'cabang_id' => $request->role === 'admin_cabang' ? $request->cabang_id : null,
            'is_active' => true,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $cabangs = Cabang::where('is_active', true)->get();
        return view('users.edit', compact('user', 'cabangs'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'username'  => ['required','string','max:50','alpha_dash', Rule::unique('users')->ignore($user->id)],
            'password'  => 'nullable|string|min:6|confirmed',
            'role'      => 'required|in:superadmin,admin_pusat,admin_cabang',
            'cabang_id' => 'required_if:role,admin_cabang|nullable|exists:cabang,id',
            'is_active' => 'boolean',
        ]);

        $data = [
            'nama'      => $request->nama,
            'username'  => $request->username,
            'role'      => $request->role,
            'cabang_id' => $request->role === 'admin_cabang' ? $request->cabang_id : null,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

   public function destroy(User $user)
{
    // tidak bisa hapus akun sendiri
    if ($user->id === auth()->id()) {
        return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
    }

    // hapus transaksi user
    Transaksi::where('user_id', $user->id)->delete();

    // hapus user
    $user->delete();

    return redirect()->route('user.index')
        ->with('success', 'User berhasil dihapus.');
}
}