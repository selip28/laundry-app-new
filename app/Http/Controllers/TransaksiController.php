<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\StatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    protected $table = 'transaksi';
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Transaksi::with(['cabang', 'layanan', 'user'])->orderByDesc('tgl_masuk');

        if ($user->isAdminCabang()) {
            $query->where('cabang_id', $user->cabang_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tgl_masuk', $request->tanggal);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%$search%")
                  ->orWhere('nama_customer', 'like', "%$search%")
                  ->orWhere('no_hp', 'like', "%$search%");
            });
        }

        $transaksis = $query->paginate(15)->withQueryString();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $layanans = Layanan::where('is_active', true)->get();
        return view('transaksi.create', compact('layanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string|max:100',
            'no_hp'         => 'required|string|max:20',
            'layanan_id'    => 'required|exists:layanan,id',
            'berat_kg'      => 'required|numeric|min:0.1|max:100',
            'catatan'       => 'nullable|string|max:500',
            'status_bayar'  => 'required|in:belum_bayar,lunas',
        ]);

        $user    = Auth::user();
        $layanan = Layanan::findOrFail($request->layanan_id);
        $cabang  = $user->cabang;

        $kode  = Transaksi::generateKode($cabang->kode);
        $total = $request->berat_kg * $layanan->harga_per_kg;
        $estimasi = Carbon::now()->addHours($layanan->estimasi_jam);

        DB::transaction(function () use ($request, $user, $layanan, $cabang, $kode, $total, $estimasi) {
            $transaksi = Transaksi::create([
                'kode_transaksi'  => $kode,
                'cabang_id'       => $cabang->id,
                'layanan_id'      => $request->layanan_id,
                'user_id'         => $user->id,
                'nama_customer'   => $request->nama_customer,
                'no_hp'           => $request->no_hp,
                'catatan'         => $request->catatan,
                'berat_kg'        => $request->berat_kg,
                'harga_per_kg'    => $layanan->harga_per_kg,
                'total_harga'     => $total,
                'status'          => 'diterima',
                'status_bayar'    => $request->status_bayar,
                'tgl_masuk'       => now(),
                'estimasi_selesai'=> $estimasi,
                'tgl_bayar'       => $request->status_bayar === 'lunas' ? now() : null,
            ]);

            StatusLog::create([
                'transaksi_id' => $transaksi->id,
                'user_id'      => $user->id,
                'status'       => 'diterima',
                'catatan'      => 'Transaksi baru diterima oleh ' . $user->nama,
            ]);
        });

        $transaksi = Transaksi::where('kode_transaksi', $kode)->first();
        return redirect()->route('transaksi.nota', $transaksi->id)
            ->with('success', 'Transaksi berhasil disimpan! Kode: ' . $kode);
    }

    public function show(Transaksi $transaksi)
    {
        $this->authorizeTransaksi($transaksi);
        $transaksi->load(['cabang', 'layanan', 'user', 'statusLogs.user']);
        return view('transaksi.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $this->authorizeTransaksi($transaksi);

        $request->validate([
            'status'  => 'required|in:diterima,diproses,selesai,diambil',
            'catatan' => 'nullable|string|max:500',
        ]);

        $statusOrder = ['diterima' => 1, 'diproses' => 2, 'selesai' => 3, 'diambil' => 4];
        if ($statusOrder[$request->status] <= $statusOrder[$transaksi->status]) {
            return back()->with('error', 'Status tidak bisa mundur.');
        }

        DB::transaction(function () use ($request, $transaksi) {
            $update = ['status' => $request->status];

            if ($request->status === 'selesai') {
                $update['tgl_selesai'] = now();
            }
            if ($request->status === 'diambil') {
                $update['tgl_diambil'] = now();
                $update['status_bayar'] = 'lunas';
                $update['tgl_bayar'] = now();
            }

            $transaksi->update($update);

            StatusLog::create([
                'transaksi_id' => $transaksi->id,
                'user_id'      => Auth::id(),
                'status'       => $request->status,
                'catatan'      => $request->catatan ?? 'Status diperbarui',
            ]);
        });

        return back()->with('success', 'Status berhasil diperbarui menjadi: ' . $transaksi->fresh()->status_label);
    }

    public function nota(Transaksi $transaksi)
    {
        $this->authorizeTransaksi($transaksi);
        $transaksi->load(['cabang', 'layanan']);
        return view('transaksi.nota', compact('transaksi'));
    }

    public function cekStatus(Request $request)
    {
        $transaksi = null;
        $error = null;

        if ($request->isMethod('post')) {
            $request->validate([
                'kode' => 'required|string',
            ], ['kode.required' => 'Masukkan kode transaksi atau nomor HP.']);

            $kode = $request->kode;
            $transaksi = Transaksi::with(['cabang', 'layanan', 'statusLogs'])
                ->where('kode_transaksi', $kode)
                ->orWhere('no_hp', $kode)
                ->orderByDesc('tgl_masuk')
                ->first();

            if (!$transaksi) {
                $error = 'Data tidak ditemukan. Periksa kembali kode transaksi atau nomor HP Anda.';
            }
        }

        return view('transaksi.cek-status', compact('transaksi', 'error'));
    }

    private function authorizeTransaksi(Transaksi $transaksi): void
    {
        $user = Auth::user();
        if ($user->isAdminCabang() && $transaksi->cabang_id !== $user->cabang_id) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }
    }
}
