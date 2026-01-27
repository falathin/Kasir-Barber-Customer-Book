<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerBookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CapsterController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\NoteController;


// Route::get('/welcome', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // baim
    Route::resource('capsters', CapsterController::class);
    // Dashboard via Controller
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // web.php
    Route::resource('customer-books', CustomerBookController::class)->names([
        'index'   => 'customer-books.index',
        'create'  => 'customer-books.create',
        'store'   => 'customer-books.store',
        'show'    => 'customer-books.show',
        'edit'    => 'customer-books.edit',
        'update'  => 'customer-books.update',
        'destroy' => 'customer-books.destroy',
    ]);


    // Tampil form proses (GET)
    Route::get('customer-books/{book}/process', [CustomerBookController::class, 'createWithCapster'])
        ->name('customer-books.createWithCap');

    // Simpan proses capster (POST) → update `$book`
    Route::post('customer-books/{book}/process', [CustomerBookController::class, 'storeWithCapster'])
        ->name('customer-books.storeWithCap');

    Route::resource('notes', NoteController::class)->except(['show']);
    
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return 'ini adalah halaman admin';
    })->name('admin.dashboard');

    Route::resource('kasirs', KasirController::class)->except(['show']);

    // Pindahkan ke sini agar capsters hanya untuk admin
    Route::resource('capsters', CapsterController::class);
});

require __DIR__ . '/auth.php';