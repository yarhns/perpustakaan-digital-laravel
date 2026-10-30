<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Depan (Publik / Landing Page)
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Rute Dashboard (Bisa diakses Admin ATAU Mode Demo)
Route::get('/dashboard', function () {
    if (!Auth::check() && !session('is_demo')) {
        return redirect()->route('login')->with('demo_error', 'Silakan login atau gunakan mode demo.');
    }
    return app(DashboardController::class)->index();
})->name('dashboard');

// 3. Rute Demo Mode
Route::get('/demo-login', function () {
    session(['is_demo' => true]);
    return redirect()->route('dashboard')->with('success', 'Selamat datang di Mode Demo! Anda dapat mencoba fitur-fitur di sini.');
})->name('demo-login');

Route::get('/demo-logout', function () {
    session()->forget('is_demo');
    return redirect()->route('landing')->with('success', 'Anda telah keluar dari Mode Demo.');
})->name('demo-logout');

// 4. Rute Koleksi Buku (CRUD)
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

// 5. Rute Data Anggota (CRUD)
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');
Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');

// 6. Rute Peminjaman & PDF
Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
Route::put('/loans/{id}/return', [LoanController::class, 'returnBook'])->name('loans.return');
Route::get('/loans/export-pdf', [LoanController::class, 'exportPdf'])->name('loans.export-pdf');

// Rute Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');