<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

Route::get("/",            [PortfolioController::class, "index"])->name("portfolio");
Route::get("/proyectos",   [PortfolioController::class, "proyectos"])->name("proyectos");
Route::get("/stack",       [PortfolioController::class, "stack"])->name("stack");
Route::get("/experiencia", [PortfolioController::class, "experiencia"])->name("experiencia");
Route::get("/contacto",    [PortfolioController::class, "contactView"])->name("contact.view");
Route::post("/contacto",   [PortfolioController::class, "contact"])->name("contact");
