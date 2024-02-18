<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", function () {
    if (!auth()->check()) {
        return redirect()->route("home");
    }
    return view("pages.auth.login");
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('home');

    Route::get('/access-denied', function () {
        return view('pages.auth.denied');
    })->name('access-denied');

    // Route::resource('transaction', TransactionController::class);
    // Route::get('transaction', [TransactionController::class,'index'])->name('transaction.index');
    // Route::get('transaction/create', [TransactionDetailController::class,'create'])->name('transaction.create');
    Route::resource('transaction', TransactionController::class);
    Route::resource('transaction/detail', TransactionDetailController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
