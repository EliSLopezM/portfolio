<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DccController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// ── Portfolio Dev ──
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/proyectos', [PortfolioController::class, 'proyectos'])->name('proyectos');
Route::get('/stack', [PortfolioController::class, 'stack'])->name('stack');
Route::get('/experiencia', [PortfolioController::class, 'experiencia'])->name('experiencia');
Route::get('/contacto', [PortfolioController::class, 'contactView'])->name('contact.view');
Route::post('/contacto', [PortfolioController::class, 'contact'])
    ->middleware(['throttle:6,1', 'sqlguard'])
    ->name('contact');

// ── Blog compartido ──
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/like', [BlogController::class, 'like'])->middleware('throttle:engage')->name('blog.like');

Route::get('/files/{name}', [FileController::class, 'show'])->where('name', '[A-Za-z0-9.]+')
	->withoutMiddleware([\Illuminate\Session\Middleware\StartSession::class, \Illuminate\View\Middleware\ShareErrorsFromSession::class, \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
	->name('files.show');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// ── DCC ──
Route::get('/dcc', [DccController::class, 'index'])->name('dcc.index');
Route::get('/dcc/blog', [DccController::class, 'blog'])->name('dcc.blog');
Route::get('/dcc/blog/{slug}', [DccController::class, 'blogShow'])->name('dcc.blog.show');
Route::post('/dcc/blog/{slug}/like', [DccController::class, 'like'])->middleware('throttle:engage')->name('dcc.blog.like');
Route::get('/dcc/contacto', [DccController::class, 'contacto'])->name('dcc.contacto');

// ── Acceso al dashboard ──
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware(['throttle:login', 'sqlguard'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// ── Dashboard (solo administrador) ──
Route::middleware('admin')->group(function () {
    Route::get('/admin', [Admin\DashboardController::class, 'index'])->name('admin.index');

    // Funciones compartidas por ambas áreas (el área la fija el middleware `area`).
    $shared = function () {
        Route::get('/', [Admin\AreaController::class, 'index'])->name('home');

        Route::get('blogs', [Admin\PostController::class, 'index'])->name('posts.index');
        Route::get('blogs/nuevo', [Admin\PostController::class, 'create'])->name('posts.create');
        Route::post('blogs', [Admin\PostController::class, 'store'])->middleware('sqlguard:content')->name('posts.store');
        Route::get('blogs/{post}/editar', [Admin\PostController::class, 'edit'])->name('posts.edit');
        Route::put('blogs/{post}', [Admin\PostController::class, 'update'])->middleware('sqlguard:content')->name('posts.update');
        Route::delete('blogs/{post}', [Admin\PostController::class, 'destroy'])->name('posts.destroy');
        Route::post('blogs/seo', [Admin\PostController::class, 'seo'])->middleware('sqlguard:content')->name('posts.seo');
        Route::post('blogs/imagen', [Admin\PostController::class, 'uploadImage'])->name('posts.image');

        Route::get('imagenes', [Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('imagenes', [Admin\MediaController::class, 'store'])->middleware('sqlguard')->name('media.store');
        Route::put('imagenes/{media}', [Admin\MediaController::class, 'update'])->middleware('sqlguard')->name('media.update');
        Route::delete('imagenes/{media}', [Admin\MediaController::class, 'destroy'])->name('media.destroy');

        Route::post('orden/{resource}', [Admin\OrderController::class, 'reorder'])->name('reorder');
        Route::post('visible/{resource}/{id}', [Admin\OrderController::class, 'toggle'])->whereNumber('id')->name('toggle');
    };

    Route::prefix('admin-dcc')->name('admin.dcc.')->middleware('area:dcc')->group(function () use ($shared) {
        $shared();
        Route::get('calendario', [Admin\EventController::class, 'index'])->name('events.index');
        Route::get('calendario/nuevo', [Admin\EventController::class, 'create'])->name('events.create');
        Route::post('calendario', [Admin\EventController::class, 'store'])->middleware('sqlguard')->name('events.store');
        Route::get('calendario/{event}/editar', [Admin\EventController::class, 'edit'])->name('events.edit');
        Route::put('calendario/{event}', [Admin\EventController::class, 'update'])->middleware('sqlguard')->name('events.update');
        Route::delete('calendario/{event}', [Admin\EventController::class, 'destroy'])->name('events.destroy');
    });

    Route::prefix('admin-develop')->name('admin.develop.')->middleware('area:develop')->group(function () use ($shared) {
        $shared();

        Route::get('ajustes', [Admin\SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('ajustes', [Admin\SettingsController::class, 'update'])->middleware('sqlguard')->name('settings.update');

        Route::get('tecnologias', [Admin\StackController::class, 'index'])->name('stack.index');
        Route::post('tecnologias/categorias', [Admin\StackController::class, 'storeCategory'])->middleware('sqlguard')->name('stack.categories.store');
        Route::get('tecnologias/categorias/{category}/editar', [Admin\StackController::class, 'editCategory'])->name('stack.categories.edit');
        Route::put('tecnologias/categorias/{category}', [Admin\StackController::class, 'updateCategory'])->middleware('sqlguard')->name('stack.categories.update');
        Route::delete('tecnologias/categorias/{category}', [Admin\StackController::class, 'destroyCategory'])->name('stack.categories.destroy');
        Route::post('tecnologias/items', [Admin\StackController::class, 'storeItem'])->middleware('sqlguard')->name('stack.items.store');
        Route::get('tecnologias/items/{item}/editar', [Admin\StackController::class, 'editItem'])->name('stack.items.edit');
        Route::put('tecnologias/items/{item}', [Admin\StackController::class, 'updateItem'])->middleware('sqlguard')->name('stack.items.update');
        Route::delete('tecnologias/items/{item}', [Admin\StackController::class, 'destroyItem'])->name('stack.items.destroy');

        Route::get('proyectos', [Admin\ProjectController::class, 'index'])->name('projects.index');
        Route::get('proyectos/nuevo', [Admin\ProjectController::class, 'create'])->name('projects.create');
        Route::post('proyectos', [Admin\ProjectController::class, 'store'])->middleware('sqlguard')->name('projects.store');
        Route::get('proyectos/{project}/editar', [Admin\ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('proyectos/{project}', [Admin\ProjectController::class, 'update'])->middleware('sqlguard')->name('projects.update');
        Route::delete('proyectos/{project}', [Admin\ProjectController::class, 'destroy'])->name('projects.destroy');

        Route::get('certificados', [Admin\CertificateController::class, 'index'])->name('certificates.index');
        Route::get('certificados/nuevo', [Admin\CertificateController::class, 'create'])->name('certificates.create');
        Route::post('certificados', [Admin\CertificateController::class, 'store'])->middleware('sqlguard')->name('certificates.store');
        Route::get('certificados/{certificate}/editar', [Admin\CertificateController::class, 'edit'])->name('certificates.edit');
        Route::put('certificados/{certificate}', [Admin\CertificateController::class, 'update'])->middleware('sqlguard')->name('certificates.update');
        Route::delete('certificados/{certificate}', [Admin\CertificateController::class, 'destroy'])->name('certificates.destroy');

        Route::get('mensajes', [Admin\MessageController::class, 'index'])->name('messages.index');
        Route::post('mensajes/masivo', [Admin\MessageController::class, 'bulk'])->middleware('sqlguard')->name('messages.bulk');
        Route::get('mensajes/{message}', [Admin\MessageController::class, 'show'])->name('messages.show');
        Route::put('mensajes/{message}', [Admin\MessageController::class, 'update'])->name('messages.update');
        Route::delete('mensajes/{message}', [Admin\MessageController::class, 'destroy'])->name('messages.destroy');
    });
});
