<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// 1. Langsung lempar ke halaman Login saat web dibuka
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Rute Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Rute Profile (Fitur Hapus Akun sudah dihilangkan sepenuhnya)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
