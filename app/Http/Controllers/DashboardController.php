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

        $totalTransaksi = CustomerBook::whereDate('created_at', $today)->count();
        $totalPendapatan = CustomerBook::whereDate('created_at', $today)->sum('price');
        $totalPengembalian = CustomerBook::whereDate('created_at', $today)
            ->where('price', '<', 0)
            ->sum('price');

        $customersToday = CustomerBook::whereDate('created_at', $today)->count();
        $customersMonth = CustomerBook::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $pendapatanBulanan = CustomerBook::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('price');
        $pendapatanTahunan = CustomerBook::whereYear('created_at', $now->year)
            ->sum('price');

        $produkTerjual = CustomerBook::whereDate('created_at', $today)
            ->whereNotNull('sell_use_product')
            ->where('sell_use_product', '!=', '')
            ->count();

        return view('index', compact(
            'totalTransaksi',
            'totalPendapatan',
            'totalPengembalian',
            'pendapatanBulanan',
            'pendapatanTahunan',
            'produkTerjual',
            'customersToday',
            'customersMonth'
        ));
    }
}