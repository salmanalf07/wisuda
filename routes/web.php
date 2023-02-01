<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\AntrianController;
use App\Models\mahasiswa64;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use PHPUnit\Framework\Constraint\Count;

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


//wisuda 64
//Route::get('/', [AntrianController::class, 'index']);

//pendaftaran
Route::get('/{wisuda65}', function ($id) {
    $get = DB::table('berkas')
        ->get();
    $str = explode("-", $id);
    if (!empty($str[1]) && !empty($str[2])) {
        if (mahasiswa64::where('card', '=', $str[0])->count() > 0) {
            $mahasiswa = mahasiswa64::with('antrian')
                ->where('card', '=', $str[0])
                ->where('loket', '=', $str[1])
                ->where('sesi', '=', $str[2])
                ->whereHas('antrian', function ($query) {
                    $query->where('skip', '=', null);
                    $query->where('status', '=', 'open');
                })
                ->paginate(20);
        } else {
            $mahasiswa = mahasiswa64::with('antrian')
                ->where('loket', '=', $str[1])
                ->where('sesi', '=', $str[2])
                ->whereHas('antrian', function ($query) {
                    $query->where('skip', '=', null);
                    $query->where('status', '=', 'open');
                })
                ->paginate(20);
        }
        return view('wisuda64/v_daftar', ['data' => $get, 'mahasiswa' => $mahasiswa]);
    } elseif ($id == "cetak_pdf") {
        return App::call('App\Http\Controllers\AntrianController@cetak_pdf');
    } else {
        $mahasiswa = mahasiswa64::with('antrian')
            ->whereHas('antrian', function ($query) {
                $query->where('skip', '=', null);
                $query->where('status', '=', 'open');
            })
            ->paginate(20);
        return view('wisuda64/v_daftar', ['data' => $get, 'mahasiswa' => $mahasiswa]);
    }
    //return $str;
});
Route::post('/search64', [DaftarController::class, 'search_maha64']);
Route::post('/skip64', [DaftarController::class, 'skip_maha64']);
Route::post('/store_antr64', [AntrianController::class, 'store_antr64']);
Route::get('/cetak_pdf', [AntrianController::class, 'cetak_pdf']);
Route::get('/sendsisa/w66', [AntrianController::class, 'send_total']);
// Route::get('/wacom', function () {
//     return view('v_wacom');
// });
// Route::get('/dashboard', [AntrianController::class, 'dashboard']);
// Route::get('/cetak/{id}', [AntrianController::class, 'cetak_page']);
//end wisuda 64




// Route::get('/data_komputer', [komputer::class, 'index']);
// Route::get('/json_komputer',  [komputer::class, 'json']);
// Route::post('/store_komputer', [komputer::class, 'store']);
// Route::post('/edit_komputer', [komputer::class, 'edit']);
// Route::put('/update_komputer/{id}', [komputer::class, 'update']);
// Route::delete('/delete_komputer/{id}/{idspe}', [komputer::class, 'destroy']);
