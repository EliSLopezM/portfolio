<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
Route::post('/contacto', [PortfolioController::class, 'contact'])->name('contact');
