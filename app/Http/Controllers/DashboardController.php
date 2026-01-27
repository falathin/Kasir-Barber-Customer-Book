<?php

namespace App\Http\Controllers;

use App\Models\CustomerBook;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function toggleStats(Request $request)
    {
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

        $query = CustomerBook::query();

        if ($user->level !== 'admin') {
            $query->where('barber_name', $user->name);
        }

        $totalTransaksi = (clone $query)
            ->whereDate('created_at', $today)
            ->where('price', '>', 0)
            ->count();

        $totalPendapatan = (clone $query)
            ->whereDate('created_at', $today)
            ->where('price', '>', 0)
            ->sum('price');

        $totalPengembalian = (clone $query)
            ->whereDate('created_at', $today)
            ->where('price', '<', 0)
            ->sum('price');

        $customersToday = (clone $query)
            ->whereDate('created_at', $today)
            ->count();

        $produkTerjual = (clone $query)
            ->whereDate('created_at', $today)
            ->whereNotNull('sell_use_product')
            ->where('sell_use_product', '!=', '')
            ->count();

        $customersMonth = (clone $query)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $pendapatanBulanan = (clone $query)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->where('price', '>', 0)
            ->sum('price');

        $pendapatanTahunan = (clone $query)
            ->whereYear('created_at', $now->year)
            ->where('price', '>', 0)
            ->sum('price');

        $pendapatanPerBarber = [];
        if ($user->level === 'admin') {
            $pendapatanPerBarber = CustomerBook::select('barber_name')
                ->selectRaw('SUM(price) as total')
                ->where('price', '>', 0)
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