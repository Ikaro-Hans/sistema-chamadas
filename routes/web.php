<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChamadaController;

Route::middleware(['auth'])->group(function () {
    // Rotas do usuário
    Route::get('/chamadas', [ChamadaController::class, 'index'])->name('chamadas.index');
    Route::post('/chamadas', [ChamadaController::class, 'store'])->name('chamadas.store');

    // Rotas do admin
    Route::middleware('can:is-admin')->group(function () {
        Route::get('/admin/chamadas', [AdminController::class, 'listarChamadas'])->name('admin.chamadas');
        Route::post('/admin/usuarios', [AdminController::class, 'criarUsuario'])->name('admin.usuarios.store');
    });
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/chamadas', [ChamadaController::class, 'index'])->name('chamadas.index');
    Route::get('/chamadas/create', [ChamadaController::class, 'create'])->name('chamadas.create');
    Route::post('/chamadas', [ChamadaController::class, 'store'])->name('chamadas.store');
});

require __DIR__.'/auth.php';
