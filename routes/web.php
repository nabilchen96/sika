<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\CheckRole;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['checkRole:admin' ]], function () { 

    // Route::get('/testcron', 'HomeController@testcron');

    Route::get('/update-taruna-server', 'TarunaController@updatetarunaserver');
    Route::get('/taruna-json', 'TarunaController@json');
    Route::get('/taruna', 'TarunaController@index');
    Route::get('/taruna/{id}', 'TarunaController@detail');
    Route::post('/updatetaruna', 'TarunaController@updatetaruna');

    Route::get('/kamar', 'KamarController@index');
    Route::post('/tambahkamar', 'KamarController@store');
    Route::post('/editkamar', 'KamarController@update');
    Route::get('/hapuskamar/{id}', 'KamarController@destroy');

    Route::get('/pelanggaran-json', 'PelanggaranController@json');
    Route::get('/pelanggaran', 'PelanggaranController@index');
    Route::post('/tambahpelanggaran', 'PelanggaranController@store');
    Route::post('/editpelanggaran', 'PelanggaranController@update');
    Route::get('/hapuspelanggaran/{id}', 'PelanggaranController@destroy');

    Route::get('/penghargaan', 'PenghargaanController@index');
    Route::post('/tambahpenghargaan', 'PenghargaanController@store');
    Route::post('/editpenghargaan', 'PenghargaanController@update');
    Route::get('/hapuspenghargaan/{id}', 'PenghargaanController@destroy');

    Route::get('/hukuman', 'HukumanController@index');
    Route::get('/hukuman-json', 'HukumanController@json');
    Route::post('/tambahhukuman', 'HukumanController@store');
    Route::post('/edithukuman', 'HukumanController@update');
    Route::get('/hapushukuman/{id}', 'HukumanController@destroy');

    Route::get('/bataspelanggaran', 'BatasPelanggaranController@index');
    Route::post('/tambahbataspelanggaran', 'BatasPelanggaranController@store');
    Route::post('/editbataspelanggaran', 'BatasPelanggaranController@update');
    Route::get('/hapusbataspelanggaran/{id}', 'BatasPelanggaranController@destroy');

    Route::get('/pengasuh', 'PengasuhController@index');
    Route::get('/pengasuh-json', 'PengasuhController@json');
    Route::get('/tambah-pengasuh', 'PengasuhController@create');
    Route::post('/simpan-pengasuh', 'PengasuhController@store');
    Route::get('/pengasuh/{id}', 'PengasuhController@edit');
    Route::post('/update-pengasuh/{email}/{nip}', 'PengasuhController@update');
    Route::get('/hapuspengasuh/{id}', 'PengasuhController@destroy');

    Route::get('/semester', 'SemesterController@index');
    Route::get('/semester-json', 'SemesterController@json');
    Route::get('/update-semester-server', 'SemesterController@updatesemesterserver');

    Route::get('/tambah-tarunakamar', 'TarunaKamarController@create');
    Route::post('/simpan-tarunakamar', 'TarunaKamarController@store');
    Route::get('/hapustarunakamar/{id}', 'TarunaKamarController@destroy');

    Route::get('/tambah-tarunapengasuh', 'AsuhanController@create');
    Route::post('/simpan-tarunapengasuh', 'AsuhanController@store');
    Route::get('/hapustarunapengasuh/{id}', 'AsuhanController@destroy'); 
});

Route::get('/tarunakamar', 'TarunaKamarController@index')->middleware(['checkRole:pengasuh,admin']);
Route::get('/tarunakamar-json', 'TarunaKamarController@kamarjson')->middleware(['checkRole:pengasuh,admin']);
Route::get('/kelompokkamartaruna-json', 'TarunaKamarController@kelompokkamarjson')->middleware(['checkRole:pengasuh,admin']);
Route::get('/tambah-tarunakamar-json', 'TarunaKamarController@tambahtarunajson')->middleware(['checkRole:pengasuh,admin']);

Route::get('/tarunapengasuh', 'AsuhanController@index')->middleware(['checkRole:pengasuh,admin']);
Route::get('/tarunapengasuh-json', 'AsuhanController@pengasuh')->middleware(['checkRole:pengasuh,admin']);
Route::get('/kelompoktarunapengasuh-json', 'AsuhanController@kelompoktaruna')->middleware(['checkRole:pengasuh,admin']);
Route::get('/tambah-tarunapengasuh-json', 'AsuhanController@tambahtarunajson')->middleware(['checkRole:pengasuh,admin']);   

Route::get('/catatanpelanggaran', 'CatatanPelanggaranController@index')->middleware(['checkRole:pengasuh,admin']);
Route::get('/catatanpelanggarantaruna-json', 'CatatanPelanggaranController@tarunajson')->middleware(['checkRole:pengasuh,admin']);
Route::get('/tambah-catatanpelanggaran/{id}', 'CatatanPelanggaranController@create')->middleware(['checkRole:pengasuh,admin']);
Route::post('/simpan-catatanpelanggaran', 'CatatanPelanggaranController@store')->middleware(['checkRole:pengasuh,admin']);
Route::post('updatecatatanpelanggaran', 'CatatanPelanggaranController@update')->middleware(['checkRole:pengasuh,admin']);
Route::get('/hapuscatatanpelanggaran/{id}', 'CatatanPelanggaranController@destroy')->middleware(['checkRole:pengasuh,admin']);

Route::get('/catatanhukuman', 'CatatanHukumanController@index')->middleware(['checkRole:pengasuh,admin']);
Route::get('/status-catatanhukuman/{id}', 'CatatanHukumanController@updatestatus')->middleware(['checkRole:pengasuh,admin']);
Route::post('/update-hukuman', 'CatatanHukumanController@updatehukuman')->middleware(['checkRole:pengasuh,admin']);

Route::get('/catatanpenghargaan', 'CatatanPenghargaanController@index')->middleware(['checkRole:pengasuh,admin']);
Route::get('/catatanpenghargaan-json', 'CatatanPenghargaanController@tarunajson')->middleware(['checkRole:pengasuh,admin']);
Route::post('/tambah-catatanpenghargaan', 'CatatanPenghargaanController@store')->middleware(['checkRole:pengasuh,admin']);
Route::post('/edit-catatanpenghargaan', 'CatatanPenghargaanController@update')->middleware(['checkRole:pengasuh,admin']);
Route::get('/hapus-catatanpenghargaan/{id}', 'CatatanPenghargaanController@destroy')->middleware(['checkRole:pengasuh,admin']);

Route::get('/catatansakit', 'CatatanSakitController@index')->middleware(['checkRole:pengasuh,admin']);
Route::post('/tambah-catatansakit', 'CatatanSakitController@store')->middleware(['checkRole:pengasuh,admin']);
Route::post('/edit-catatansakit', 'CatatanSakitController@update')->middleware(['checkRole:pengasuh,admin']);
Route::get('/hapus-catatansakit/{id}', 'CatatanSakitController@destroy')->middleware(['checkRole:pengasuh,admin']);

Route::get('/catatanperizinan', 'CatatanPerizinanController@index')->middleware(['checkRole:pengasuh,admin']);
Route::post('/tambah-catatanperizinan', 'CatatanPerizinanController@store');
Route::post('/edit-catatanperizinan', 'CatatanPerizinanController@update')->middleware(['checkRole:pengasuh,admin']);
Route::get('/hapus-catatanperizinan/{id}', 'CatatanPerizinanController@destroy')->middleware(['checkRole:pengasuh,admin']);