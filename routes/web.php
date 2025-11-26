<?php

use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 🏠 Página pública de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🧠 Dashboard protegido
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 🔐 Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // 📦 Products
    Route::resource('products', ProductController::class);
    Route::get('products/pdf/{id}', [ProductController::class, 'generatePDF'])->name('pdf');

    // 🔄 Movements
    Route::resource('movements', MovementController::class);
    Route::get('movements/pdf/{id}', [MovementController::class, 'generatePDF'])->name('movements.pdf');

    // 📊 Reportes
    Route::get('reports', [\App\Http\Controllers\ReportsController::class, 'index'])->name('reports.index');
    Route::get('reports/pdf', [\App\Http\Controllers\ReportsController::class, 'exportPdf'])->name('reports.exportPdf');

    // 👤 Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🧙‍♂️ Rutas de autenticación Breeze
require __DIR__.'/auth.php';
