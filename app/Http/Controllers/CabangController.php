<?php
// app/Http/Controllers/CabangController.php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CabangController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::withCount('transaksis')
            ->orderBy('nama')
            ->paginate(15);

        return view('cabangs.index', compact('cabangs'));
    }

    public function create()
    {
        return view('cabangs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'kode'     => 'required|string|max:10|unique:cabang,kode|uppercase',
            'alamat'   => 'required|string|max:255',
            'telepon'  => 'nullable|string|max:20',
        ], [
            'kode.unique' => 'Kode cabang sudah digunakan.',
        ]);

        Cabang::create([
            'nama'      => $request->nama,
            'kode'      => strtoupper($request->kode),
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
            'is_active' => true,
        ]);

        return redirect()
            ->route('cabang.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(Cabang $cabang)
    {
        return view('cabangs.edit', compact('cabang'));
    }

    public function update(Request $request, Cabang $cabang)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'kode'      => [
                'required',
                'string',
                'max:10',
                Rule::unique('cabang', 'kode')->ignore($cabang->id),
            ],
            'alamat'    => 'required|string|max:255',
            'telepon'   => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $cabang->update([
            'nama'      => $request->nama,
            'kode'      => strtoupper($request->kode),
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('cabang.index')
            ->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Cabang $cabang)
    {
        if ($cabang->transaksis()->exists()) {
            return back()->with(
                'error',
                'Cabang tidak bisa dihapus karena memiliki data transaksi.'
            );
        }

        $cabang->delete();

        return redirect()
            ->route('cabang.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }
}