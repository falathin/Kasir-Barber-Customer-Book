<?php

namespace App\Http\Controllers;

use App\Models\CustomerBook;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function toggleStats(Request $request)
    {
        // toggle value di session, default true
        $visible = session('stats_visible', true);
        session(['stats_visible' => !$visible]);

        return response()->json([
            'visible' => session('stats_visible')
        ]);
    }

    public function index()
    {
        $today = today();
        $now = now();
        $user = auth()->user();

        // Ambil query dasar
        $query = CustomerBook::query();

        // Jika bukan admin, filter berdasarkan barber_name
        if ($user->level !== 'admin') {
            $query->where('barber_name', $user->name);
        }

        $totalTransaksi = (clone $query)->whereDate('created_at', $today)->count();
        $totalPendapatan = (clone $query)->whereDate('created_at', $today)->sum('price');
        $totalPengembalian = (clone $query)->whereDate('created_at', $today)
            ->where('price', '<', 0)
            ->sum('price');

        $customersToday = (clone $query)->whereDate('created_at', $today)->count();
        $customersMonth = (clone $query)->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $pendapatanBulanan = (clone $query)->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('price');
        $pendapatanTahunan = (clone $query)->whereYear('created_at', $now->year)->sum('price');

        $produkTerjual = (clone $query)->whereDate('created_at', $today)
            ->whereNotNull('sell_use_product')
            ->where('sell_use_product', '!=', '')
            ->count();

        // Jika admin, ambil daftar pendapatan per barber
        $pendapatanPerBarber = [];
        if ($user->level === 'admin') {
            $pendapatanPerBarber = CustomerBook::select('barber_name')
                ->selectRaw('SUM(price) as total')
                ->groupBy('barber_name')
                ->orderByDesc('total')
                ->get();
        }

        return view('index', compact(
            'totalTransaksi',
            'totalPendapatan',
            'totalPengembalian',
            'pendapatanBulanan',
            'pendapatanTahunan',
            'produkTerjual',
            'customersToday',
            'customersMonth',
            'pendapatanPerBarber'
        ));
    }


}