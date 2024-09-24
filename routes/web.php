<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::post('/url/short/create', [App\Http\Controllers\HomeController::class, 'shortUrl'])->name('url_short')->middleware('auth');
Route::get('/link/{slug}', [App\Http\Controllers\HomeController::class, 'link']);
