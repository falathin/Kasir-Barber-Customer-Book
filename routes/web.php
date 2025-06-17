<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerBookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CapsterController;

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
