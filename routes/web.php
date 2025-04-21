<?php

use App\Http\Controllers\{
    PermissionController,
    RoleController
};
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    // Permissions routes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');

    // Roles routes
    Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('role.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('role.update');
});

require __DIR__ . '/auth.php';
