<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::withCount('transaksis')
            ->orderBy('nama')
            ->paginate(15);

        return view('layanans.index', compact('layanans'));
    }

    public function create()
    {
        return view('layanans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100|unique:layanan,nama',
            'harga_per_kg'  => 'required|numeric|min:0',
            'estimasi_jam'  => 'required|integer|min:1',
            'deskripsi'     => 'nullable|string|max:255',
        ]);

        Layanan::create([
            'nama'          => $request->nama,
            'harga_per_kg'  => $request->harga_per_kg,
            'estimasi_jam'  => $request->estimasi_jam,
            'deskripsi'     => $request->deskripsi,
            'is_active'     => true,
        ]);

        return redirect()
            ->route('layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        return view('layanans.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('layanan', 'nama')->ignore($layanan->id),
            ],
            'harga_per_kg'  => 'required|numeric|min:0',
            'estimasi_jam'  => 'required|integer|min:1',
            'deskripsi'     => 'nullable|string|max:255',
            'is_active'     => 'boolean',
        ]);

        $layanan->update([
            'nama'          => $request->nama,
            'harga_per_kg'  => $request->harga_per_kg,
            'estimasi_jam'  => $request->estimasi_jam,
            'deskripsi'     => $request->deskripsi,
            'is_active'     => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        if ($layanan->transaksis()->exists()) {
            return back()->with(
                'error',
                'Layanan tidak bisa dihapus karena sudah digunakan dalam transaksi.'
            );
        }

        $layanan->delete();

        return redirect()
            ->route('layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}