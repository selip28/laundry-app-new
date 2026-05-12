<?php
// app/Http/Controllers/LaporanController.php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Transaksi;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user      = Auth::user();
        $cabangs   = Cabang::where('is_active', true)->get();
        $bulan     = $request->get('bulan', now()->month);
        $tahun     = $request->get('tahun', now()->year);
        $cabangId  = $request->get('cabang_id');

        $query = Transaksi::with(['cabang', 'layanan'])
            ->whereMonth('tgl_masuk', $bulan)
            ->whereYear('tgl_masuk', $tahun);

        if ($user->isAdminCabang()) {
            $query->where('cabang_id', $user->cabang_id);
        } elseif ($cabangId) {
            $query->where('cabang_id', $cabangId);
        }

        $transaksis = $query->orderByDesc('tgl_masuk')->paginate(20)->withQueryString();

        // Ringkasan
        $summaryQuery = Transaksi::whereMonth('tgl_masuk', $bulan)->whereYear('tgl_masuk', $tahun);
        if ($user->isAdminCabang()) {
            $summaryQuery->where('cabang_id', $user->cabang_id);
        } elseif ($cabangId) {
            $summaryQuery->where('cabang_id', $cabangId);
        }

        $summary = [
            'total_transaksi'  => $summaryQuery->count(),
            'total_pendapatan' => $summaryQuery->where('status_bayar', 'lunas')->sum('total_harga'),
            'total_berat'      => $summaryQuery->sum('berat_kg'),
        ];

        // Pendapatan per cabang (hanya pusat/superadmin)
        $perCabang = [];
        if (!$user->isAdminCabang()) {
            $perCabang = Transaksi::with('cabang')
                ->selectRaw('cabang_id, COUNT(*) as total_trx, SUM(total_harga) as total_pendapatan')
                ->whereMonth('tgl_masuk', $bulan)
                ->whereYear('tgl_masuk', $tahun)
                ->where('status_bayar', 'lunas')
                ->groupBy('cabang_id')
                ->get();
        }

        return view('laporan.index', compact('transaksis', 'summary', 'cabangs', 'bulan', 'tahun', 'cabangId', 'perCabang'));
    }

    public function exportPdf(Request $request)
    {
        $user     = Auth::user();
        $bulan    = $request->get('bulan', now()->month);
        $tahun    = $request->get('tahun', now()->year);
        $cabangId = $request->get('cabang_id');

        $query = Transaksi::with(['cabang', 'layanan'])
            ->whereMonth('tgl_masuk', $bulan)
            ->whereYear('tgl_masuk', $tahun);

        if ($user->isAdminCabang()) {
            $query->where('cabang_id', $user->cabang_id);
            $cabang = $user->cabang;
        } elseif ($cabangId) {
            $query->where('cabang_id', $cabangId);
            $cabang = Cabang::find($cabangId);
        } else {
            $cabang = null;
        }

        $transaksis = $query->orderByDesc('tgl_masuk')->get();

        $summary = [
            'total_transaksi'  => $transaksis->count(),
            'total_pendapatan' => $transaksis->where('status_bayar', 'lunas')->sum('total_harga'),
            'total_berat'      => $transaksis->sum('berat_kg'),
        ];

        $namaBulan = Carbon::create($tahun, $bulan)->translatedFormat('F Y');

        $pdf = Pdf::loadView('laporan.pdf', compact('transaksis', 'summary', 'cabang', 'namaBulan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("laporan-laundry-{$bulan}-{$tahun}.pdf");
    }
}