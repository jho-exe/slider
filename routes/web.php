<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

Route::get('/', [ImageController::class, 'index']);
Route::get('/admin', [ImageController::class, 'admin'])->name('image.admin');

// Rutas para guardar, actualizar y eliminar imágenes
Route::post('/admin/images', [ImageController::class, 'store'])->name('image.store');
Route::put('/admin/images/{image}', [ImageController::class, 'update'])->name('image.update');
Route::delete('/admin/images/{image}', [ImageController::class, 'destroy'])->name('image.destroy');
