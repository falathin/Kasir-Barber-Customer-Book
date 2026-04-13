<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerBookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CapsterController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CustomerBookSalesExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Dashboard (wajib login + verified)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTH USER (ADMIN & KASIR)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard utama
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER BOOK
    |--------------------------------------------------------------------------
    */
    Route::resource('customer-books', CustomerBookController::class)->names([
        'index'   => 'customer-books.index',
        'create'  => 'customer-books.create',
        'store'   => 'customer-books.store',
        'show'    => 'customer-books.show',
        'edit'    => 'customer-books.edit',
        'update'  => 'customer-books.update',
        'destroy' => 'customer-books.destroy',
    ]);

    // Proses capster
    Route::get('customer-books/{book}/process', [CustomerBookController::class, 'createWithCapster'])
        ->name('customer-books.createWithCap');

    Route::post('customer-books/{book}/process', [CustomerBookController::class, 'storeWithCapster'])
        ->name('customer-books.storeWithCap');

    /*
    |--------------------------------------------------------------------------
    | NOTES
    |--------------------------------------------------------------------------
    */
    Route::resource('notes', NoteController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL (LOGIN WAJIB)
    |--------------------------------------------------------------------------
    */
    Route::get('/sales/export', [CustomerBookSalesExportController::class, 'index'])
        ->name('sales.export.form');

    Route::get('/sales/export/download', [CustomerBookSalesExportController::class, 'export'])
        ->name('sales.export.download');
});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', function () {
        return 'ini adalah halaman admin';
    })->name('admin.dashboard');

    // Kasir management
    Route::resource('kasirs', KasirController::class)->except(['show']);

    // Capster hanya admin
    Route::resource('capsters', CapsterController::class);
});

require __DIR__ . '/auth.php';