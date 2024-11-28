<?php

use App\Http\Controllers\SiswaController;
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

Route::post('/', [SiswaController::class, 'login_post'])->name('login_post')->middleware('guest');
Route::get('/', [SiswaController::class, 'login'])->name('login')->middleware('guest');
Route::get('/home', [SiswaController::class, 'home'])->name('home')->middleware('auth');
Route::post('/home', [SiswaController::class, 'post_user'])->name('home')->middleware('auth');
Route::get('/logout', [SiswaController::class, 'logout'])->name('logout')->middleware('auth');