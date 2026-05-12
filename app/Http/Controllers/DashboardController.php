<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdminCabang()) {
            return $this->dashboardCabang($user);
        } elseif ($user->isAdminPusat()) {
            return $this->dashboardPusat();
        } else {
            return $this->dashboardSuperAdmin();
        }
    }

    private function dashboardCabang($user)
    {
        $cabangId = $user->cabang_id;
        $today = Carbon::today();

        $stats = [
            'total_hari_ini'  => Transaksi::where('cabang_id', $cabangId)->whereDate('tgl_masuk', $today)->count(),
            'diterima'        => Transaksi::where('cabang_id', $cabangId)->where('status', 'diterima')->count(),
            'diproses'        => Transaksi::where('cabang_id', $cabangId)->where('status', 'diproses')->count(),
            'selesai'         => Transaksi::where('cabang_id', $cabangId)->where('status', 'selesai')->count(),
            'pendapatan_hari' => Transaksi::where('cabang_id', $cabangId)->whereDate('tgl_masuk', $today)->where('status_bayar', 'lunas')->sum('total_harga'),
            'pendapatan_bulan'=> Transaksi::where('cabang_id', $cabangId)->whereMonth('tgl_masuk', now()->month)->where('status_bayar', 'lunas')->sum('total_harga'),
        ];

        $transaksiTerbaru = Transaksi::with(['layanan'])
            ->where('cabang_id', $cabangId)
            ->orderByDesc('tgl_masuk')
            ->limit(10)
            ->get();

        return view('dashboard.cabang', compact('stats', 'transaksiTerbaru', 'user'));
    }

    private function dashboardPusat()
    {
        $cabangs = Cabang::withCount('transaksis')->get();

        $stats = [
            'total_transaksi'   => Transaksi::count(),
            'total_pendapatan'  => Transaksi::where('status_bayar', 'lunas')->sum('total_harga'),
            'total_cabang'      => Cabang::where('is_active', true)->count(),
            'transaksi_bulan'   => Transaksi::whereMonth('tgl_masuk', now()->month)->count(),
        ];

        // Grafik pendapatan 6 bulan terakhir per cabang
        $grafikData = $this->getGrafikPendapatan();

        // Layanan terlaris
        $layananTerlaris = Transaksi::select('layanan_id', DB::raw('COUNT(*) as total'))
            ->with('layanan')
            ->groupBy('layanan_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Cabang terlaris
        $cabangTerlaris = Transaksi::select('cabang_id', DB::raw('COUNT(*) as total'), DB::raw('SUM(total_harga) as pendapatan'))
            ->with('cabang')
            ->groupBy('cabang_id')
            ->orderByDesc('total')
            ->get();

        return view('dashboard.pusat', compact('stats', 'cabangs', 'grafikData', 'layananTerlaris', 'cabangTerlaris'));
    }

    private function dashboardSuperAdmin()
    {
        $stats = [
            'total_users'       => User::count(),
            'total_cabang'      => Cabang::count(),
            'total_layanan'     => Layanan::count(),
            'total_transaksi'   => Transaksi::count(),
            'total_pendapatan'  => Transaksi::where('status_bayar', 'lunas')->sum('total_harga'),
        ];

        $grafikData = $this->getGrafikPendapatan();
        $cabangTerlaris = Cabang::withCount('transaksis')->orderByDesc('transaksis_count')->get();

        return view('dashboard.superadmin', compact('stats', 'grafikData', 'cabangTerlaris'));
    }

    private function getGrafikPendapatan(): array
    {
        $labels = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $labels[] = $bulan->translatedFormat('M Y');
            $data[] = Transaksi::whereYear('tgl_masuk', $bulan->year)
                ->whereMonth('tgl_masuk', $bulan->month)
                ->where('status_bayar', 'lunas')
                ->sum('total_harga');
        }

        return ['labels' => $labels, 'data' => $data];
    }
}