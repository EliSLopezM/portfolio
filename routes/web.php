<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DccController;

// ── Portfolio Dev ──
Route::get('/',            [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/proyectos',   [PortfolioController::class, 'proyectos'])->name('proyectos');
Route::get('/stack',       [PortfolioController::class, 'stack'])->name('stack');
Route::get('/experiencia', [PortfolioController::class, 'experiencia'])->name('experiencia');
Route::get('/contacto',    [PortfolioController::class, 'contactView'])->name('contact.view');
Route::post('/contacto',   [PortfolioController::class, 'contact'])->name('contact');

// ── Blog compartido ──
Route::get('/blog',        [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// ── DCC ──
Route::get('/dcc',               [DccController::class, 'index'])->name('dcc.index');
Route::get('/dcc/blog',          [DccController::class, 'blog'])->name('dcc.blog');
Route::get('/dcc/blog/{slug}',   [DccController::class, 'blogShow'])->name('dcc.blog.show');
Route::get('/dcc/contacto',      [DccController::class, 'contacto'])->name('dcc.contacto');