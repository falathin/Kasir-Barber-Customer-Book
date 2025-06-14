<?php

namespace App\Http\Controllers;

use App\Models\CustomerBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total transaksi hari ini
        $totalTransaksi = CustomerBook::whereDate('created_at', today())->count();

        // Total pendapatan hari ini
        $totalPendapatan = CustomerBook::whereDate('created_at', today())->sum(DB::raw('CAST(price AS UNSIGNED)'));

        // Estimasi produk terjual dari data "sell_use_product" yang diisi (anggap 1 baris = 1 produk)
        $produkTerjual = CustomerBook::whereDate('created_at', today())
                            ->whereNotNull('sell_use_product')
                            ->where('sell_use_product', '!=', '')
                            ->count();

        // Komisi kasir (misal 10% dari total pendapatan)
        $komisiKasir = $totalPendapatan * 0.1;

        return view('index', compact(
            'totalTransaksi',
            'totalPendapatan',
            'produkTerjual',
            'komisiKasir'
        ));
    }
}