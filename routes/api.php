<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Siswa
Route::get('/user/{created_at}', [AuthController::class, 'cari_user']);
Route::put('/userUpdate/{created_at}', [AuthController::class, 'ubah_user_post']);
Route::get('/user', [AuthController::class, 'user']);
Route::get('/siswa', [SiswaController::class, 'index']);
Route::get('/showsiswa/{created_at}', [SiswaController::class, 'show']);
Route::delete('/delsiswa/{created_at}', [SiswaController::class, 'destroy']);
Route::post('/tambah_siswa', [SiswaController::class, 'store']);
Route::put('/editsiswa/{id}', [SiswaController::class, 'update']);
Route::get('/carisiswa/{keyword}', [SiswaController::class, 'carisiswa']);
Route::post('/registrasi', [AuthController::class, 'registrasi']);
Route::post('/login', [AuthController::class, 'login']);