<?php

namespace App\Http\Controllers;

use App\Exports\CustomerBookSalesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class CustomerBookSalesExportController extends Controller
{
    /**
     * Halaman form export (ADMIN ONLY)
     */
    public function index()
    {
        // 🔥 CEK ADMIN
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        return view('customer-books.export-sales');
    }

    /**
     * Proses export Excel (ADMIN ONLY)
     */
    public function export(Request $request)
    {
        // 🔥 CEK ADMIN
        if (auth()->user()->level !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        // ✅ VALIDASI
        $request->validate([
            'from' => ['required', 'date'],
            'to'   => ['required', 'date', 'after_or_equal:from'],
        ]);

        // ✅ PARSE DATE
        $from = Carbon::parse($request->from)->startOfDay();
        $to   = Carbon::parse($request->to)->endOfDay();

        // ✅ NAMA FILE
        $filename = 'laporan_penjualan_'
            . $from->format('Ymd')
            . '_sd_'
            . $to->format('Ymd')
            . '.xlsx';

        // ✅ EXPORT (TANPA FILTER USER)
        return Excel::download(
            new CustomerBookSalesExport($from, $to),
            $filename
        );
    }
}