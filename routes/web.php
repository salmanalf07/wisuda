<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\AntrianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AntrianController::class, 'index']);

//pendaftaran
Route::get('/daftar', function () {
    return view('v_daftar');
});
Route::post('/search', [DaftarController::class, 'search_maha']);
Route::post('/search_nim', [DaftarController::class, 'search_nim']);
Route::post('/create_antrian', [DaftarController::class, 'store']);
//antrian
Route::post('/search_antrian', [AntrianController::class, 'search_antrian']);
Route::post('/store_antr', [AntrianController::class, 'store_antr']);
Route::get('/wacom', function () {
    return view('v_wacom');
});
Route::get('/dashboard', [AntrianController::class, 'dashboard']);
Route::get('/cetak/{id}', [AntrianController::class, 'cetak_page']);

// Route::get('/data_komputer', [komputer::class, 'index']);
// Route::get('/json_komputer',  [komputer::class, 'json']);
// Route::post('/store_komputer', [komputer::class, 'store']);
// Route::post('/edit_komputer', [komputer::class, 'edit']);
// Route::put('/update_komputer/{id}', [komputer::class, 'update']);
// Route::delete('/delete_komputer/{id}/{idspe}', [komputer::class, 'destroy']);
