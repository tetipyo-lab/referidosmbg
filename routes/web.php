<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\PageController;

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

Route::get('/', function () {
    return redirect('/admin'); // Redirige a la ruta /admin
});
/**
 * Ruta cuando envia el slug a validar y redirigir
 */
Route::get('link/{slug}', [LinkController::class, 'validateSlug'])->name('link.validate');

Route::get('page', [PageController::class, 'index'])->name('page');