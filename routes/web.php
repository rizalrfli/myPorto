<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AIController;

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

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');

// AI Chat Routes
Route::post('/api/ai/chat', [AIController::class, 'chat'])->name('ai.chat');

// Foto Profil Routes
Route::post('/api/upload-foto', [PortfolioController::class, 'uploadFoto'])->name('upload.foto');
Route::delete('/api/hapus-foto', [PortfolioController::class, 'hapusFoto'])->name('hapus.foto');
