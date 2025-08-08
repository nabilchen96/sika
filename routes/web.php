<?php

use Illuminate\Support\Facades\Route;

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

Route::get('pengumuman', 'PengumumanController@index');
Route::get('peraturan', 'PeraturanController@index');
Route::get('detailberita/{id}', 'PengumumanController@detail');
Route::get('statistik-front', function(){
    return view('statistik');
});

route::get('coba', 'BeritaController@coba');

Route::get('/login-sso', 'AuthController@login')->name('login');

Route::get('/logout', function () {

    Auth::logout();

    return redirect('/');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth']);
Route::get('/total-taruna', 'HomeController@totalTaruna');
Route::get('/pelanggaran-penghargaan-terbanyak', 'HomeController@PelanggaranPenghargaanTerbanyak');

//MOBILE LOGIN
Route::get('/mobile/login', 'mobile\AuthController@login')->name('mobile/login');
Route::post('/mobile/loginProses', 'mobile\AuthController@loginProses')->name('mobile/loginProses');

//LAMARAN KERJA
Route::post('/tambah-lamaran-kerja', 'LamaranKerjaController@store');

Route::get('/mobile/logout', function () {

  Auth::logout();
  return redirect('mobile/login');

})->name('mobile/logout');

//route for admin dan pusbangkar
Route::group(['middleware' => ['checkRole:admin,pusbangkar' ]], function () { 

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

    Route::get('/user', 'UserController@index');
    Route::post('/tambahuser', 'UserController@store');
    Route::post('/edituser', 'UserController@update');
    Route::post('/hapususer', 'UserController@delete');

    Route::get('/update-taruna-server', 'TarunaController@updatetarunaserver');
    Route::get('/taruna-json', 'TarunaController@json');
    Route::get('/taruna', 'TarunaController@index');
    Route::get('/taruna/{id}', 'TarunaController@detail');
    Route::post('/updatetaruna', 'TarunaController@updatetaruna');
    Route::get('/exporttaruna', 'TarunaController@export');

    Route::get('/kamar', 'KamarController@index');
    Route::post('/tambahkamar', 'KamarController@store');
    Route::post('/editkamar', 'KamarController@update');
    Route::get('/hapuskamar/{id}', 'KamarController@destroy');

    Route::get('/pelanggaran-json', 'PelanggaranController@json');
    Route::get('/pelanggaran', 'PelanggaranController@index');
    Route::post('/tambahpelanggaran', 'PelanggaranController@store');
    Route::post('/editpelanggaran', 'PelanggaranController@update');
    Route::get('/hapuspelanggaran/{id}', 'PelanggaranController@destroy');
    Route::get('/exportpelanggaran', 'PelanggaranController@export');

    Route::get('/penghargaan', 'PenghargaanController@index');
    Route::post('/tambahpenghargaan', 'PenghargaanController@store');
    Route::post('/editpenghargaan', 'PenghargaanController@update');
    Route::get('/hapuspenghargaan/{id}', 'PenghargaanController@destroy');
    Route::get('/exportpenghargaan', 'PenghargaanController@export');

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

    Route::get('/kordinatorpengasuh', 'KordinatorPengasuhController@index');
    Route::post('/simpankordinatorpengasuh', 'KordinatorPengasuhController@store');
    Route::get('/hapuskordinatorpengasuh/{id}', 'KordinatorPengasuhController@destroy');

    Route::get('/semester', 'SemesterController@index');
    Route::get('/semester-json', 'SemesterController@json');
    Route::get('/update-semester-server', 'SemesterController@updatesemesterserver');

    Route::get('/temasurat', 'TemplateController@index');
    Route::post('/simpantemplatesurat', 'TemplateController@store');
    Route::post('/edittemplatesurat', 'TemplateController@update');
    Route::get('/hapustemasurat/{id}', 'TemplateController@destroy');

    Route::get('/aturannilaisamapta', 'AturanNilaiSamaptaController@index');
    Route::post('/tambahaturannilaisamapta', 'AturanNilaiSamaptaController@store');
    Route::post('/editaturannilaisamapta', 'AturanNilaiSamaptaController@update');
    Route::get('/hapusaturannilaisamapta/{id}', 'AturanNilaiSamaptaController@destroy');

    Route::get('/aturannilaibbi', 'AturanNilaibbiController@index');
    Route::post('/tambahaturannilaibbi', 'AturanNilaibbiController@store');
    Route::post('/editaturannilaibbi', 'AturanNilaibbiController@update');
    Route::get('/hapusaturannilaibbi/{id}', 'AturanNilaibbiController@destroy');

    Route::get('/komponensoftskill', 'KomponenSoftskillController@index');
    Route::post('/tambahkomponensoftskill', 'KomponenSoftskillController@store');
    Route::post('/editkomponensoftskill', 'KomponenSoftskillController@update');
    Route::get('/hapuskomponensoftskill/{id}', 'KomponenSoftskillController@destroy');

    Route::get('/dewankehormatan', 'DewanKehormatanController@index');
    Route::post('/tambahdewan', 'DewanKehormatanController@store');
    Route::post('/editdewan', 'DewanKehormatanController@update');
    Route::get('/hapusdewan/{id}', 'DewanKehormatanController@destroy');

    Route::post('/simpangrupkordinasipengasuh', 'GrupKordinasiPengasuhController@store');
    Route::get('/hapusgrupkordinasipengasuh/{id}', 'GrupKordinasiPengasuhController@destroy');

    Route::get('/tambah-tarunakamar', 'TarunaKamarController@create');
    Route::post('/simpan-tarunakamar', 'TarunaKamarController@store');
    Route::get('/hapustarunakamar/{id}', 'TarunaKamarController@destroy');

    Route::get('/tambah-tarunapengasuh', 'AsuhanController@create');
    Route::post('/simpan-tarunapengasuh', 'AsuhanController@store');
    Route::get('/hapustarunapengasuh/{id}', 'AsuhanController@destroy'); 

    Route::get('/alumni', 'AlumniController@index');
    Route::get('/alumni-json', 'AlumniController@json');
    Route::get('/tambah-alumni-json', 'AlumniController@tarunajson');
    Route::get('/tambah-alumni', 'AlumniController@create');
    Route::post('/simpan-alumni', 'AlumniController@store');
    Route::post('/hapus-alumni', 'AlumniController@delete');

    Route::get('/kuesioner', 'KuesionerController@index');
    Route::post('/tambah-kuesioner', 'KuesionerController@store');
    Route::get('/hapuskuesioner/{id}', 'KuesionerController@destroy');

    Route::get('/detail-kuesioner/{id}', 'DetailKuesionerController@index');
    Route::post('/tambah-soal-kuesioner', 'DetailKuesionerController@store');
    Route::post('/edit-soal-kuesioner', 'DetailKuesionerController@update');
    Route::get('/hapus-soal-kuesioner/{id}', 'DetailKuesionerController@destroy');
    Route::get('/statistikdetailkuesioner/{id}', 'DetailKuesionerController@statistik');

    Route::get('/lamaran-kerja', 'LamaranKerjaController@index');
});

Route::group(['middleware' => ['checkMobileRole:admin,pusbangkar']], function(){
    
    //ROUTE MOBILE
    Route::get('/mobile/welcome', 'mobile\WelcomeController@index');
    
    //LARI
    Route::get('/mobile/lari', 'mobile\LariController@index');
    Route::post('/mobile/store-lari', 'mobile\LariController@store');
    
    //PUSH UP
    Route::get('/mobile/pushup', 'mobile\PushUpController@index');
    Route::post('/mobile/store-pushup', 'mobile\PushUpController@store');
    
    //SIT UP
    Route::get('/mobile/situp', 'mobile\SitUpController@index');
    Route::post('/mobile/store-situp', 'mobile\SitUpController@store');
    
    //SHUTTLE RUN
    Route::get('/mobile/shuttlerun', 'mobile\ShuttleRunController@index');
    Route::post('/mobile/store-shuttlerun', 'mobile\ShuttleRunController@store');
    
    //BBI
    Route::get('/mobile/bbi', 'mobile\BBIController@index');
    Route::post('/mobile/store-bbi', 'mobile\BBIController@store');
    
    //PELANGGARAN
    Route::get('/mobile/pelanggaran', 'mobile\PelanggaranController@index');
    Route::get('/mobile/detail-pelanggaran/{id}', 'mobile\PelanggaranController@detail');
    Route::post('/mobile/store-pelanggaran', 'mobile\PelanggaranController@store');
    
    //PENGHARGAAN
    Route::get('/mobile/penghargaan', 'mobile\PenghargaanController@index');
    Route::post('/mobile/store-penghargaan', 'mobile\PenghargaanController@store');
    
    //PEMBINAAN
    Route::get('/mobile/pembinaan', 'mobile\PembinaanController@index');
    
    //BERITA
    Route::get('/mobile/berita', 'mobile\BeritaController@index');
    Route::get('/mobile/detail-berita', function(){ return view('mobile.detail-berita'); });
    
    //NILAI TARUNA
    Route::get('/mobile/nilai', 'mobile\NilaiController@index');
    
    //PELANGGARAN
    Route::get('/mobile/nilai-pelanggaran', 'mobile\NilaiController@nilaiPelanggaran');
    
    //PENGHARGAAN
    Route::get('/mobile/nilai-penghargaan', 'mobile\NilaiController@nilaiPenghargaan');
    
    //SOFTSKILL
    Route::get('/mobile/softskill/{id}', 'mobile\SoftskillController@detail');
    Route::post('/mobile/store-softskill', 'mobile\SoftskillController@store');
    Route::get('/mobile/detail-softskill/{id_mahasiswa}/{jenis_softskill}', 'mobile\SoftskillController@detailSoftskillTaruna');
    
    //NILAI SOFTSKILL
    Route::get('/mobile/nilai-softskill', 'mobile\SoftskillController@nilai');
});


Route::get('laporan-pelanggaran', 'LaporanPelanggaranController@index');
Route::get('data-laporan-pelanggaran', 'LaporanPelanggaranController@data');

Route::get('laporan-penghargaan', 'LaporanPenghargaanController@index');
Route::get('data-laporan-penghargaan', 'LaporanPenghargaanController@data');

Route::get('laporan-penilaian', 'LaporanPenilaianController@index');
Route::get('data-laporan-penilaian', 'LaporanPenilaianController@data');
Route::get('data-laporan-jasmani', 'LaporanPenilaianController@dataJasmani');

Route::get('laporan-bbi', 'LaporanBBIController@index');
Route::get('data-laporan-bbi', 'LaporanBBIController@data');
Route::get('data-laporan-bbi2', 'LaporanBBIController@data2');

Route::get('/tarunakamar', 'TarunaKamarController@index')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/tarunakamar-json', 'TarunaKamarController@kamarjson')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/kelompokkamartaruna-json', 'TarunaKamarController@kelompokkamarjson')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/tambah-tarunakamar-json', 'TarunaKamarController@tambahtarunajson')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/tarunakamarexport', 'TarunaKamarController@export')->middleware(['checkRole:pengasuh,admin,pusbangkar']);

Route::get('/tarunapengasuh', 'AsuhanController@index')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/tarunapengasuh-json', 'AsuhanController@pengasuh')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/kelompoktarunapengasuh-json', 'AsuhanController@kelompoktaruna')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/tambah-tarunapengasuh-json', 'AsuhanController@tambahtarunajson')->middleware(['checkRole:pengasuh,admin,pusbangkar']);  
Route::get('/tarunapengasuhexport', 'AsuhanController@export')->middleware(['checkRole:pengasuh,admin,pusbangkar']); 

Route::get('/catatanpelanggaran', 'CatatanPelanggaranController@index')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::get('/catatanpelanggarantaruna-json', 'CatatanPelanggaranController@tarunajson')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::get('/tambah-catatanpelanggaran/{id}', 'CatatanPelanggaranController@create')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::post('/simpan-catatanpelanggaran', 'CatatanPelanggaranController@store')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::post('updatecatatanpelanggaran', 'CatatanPelanggaranController@update')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/hapuscatatanpelanggaran/{id}', 'CatatanPelanggaranController@destroy')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/catatanpelanggarandetail/{id}', 'CatatanPelanggaranController@Detail')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::get('/catatanpelanggaranexportall', 'CatatanPelanggaranController@exportall')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/catatanpelanggaranexportperson/{id}', 'CatatanPelanggaranController@exportperson')->middleware(['checkRole:pengasuh,admin,pusbangkar']);

Route::get('/catatanhukuman', 'CatatanHukumanController@index')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::get('/status-catatanhukuman/{id}', 'CatatanHukumanController@updatestatus')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::post('/update-hukuman', 'CatatanHukumanController@updatehukuman')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/catatanhukumanexport', 'CatatanHukumanController@export')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);

Route::get('/catatanpenghargaan', 'CatatanPenghargaanController@index')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna,poliklinik']);
Route::get('/catatanpenghargaan-json', 'CatatanPenghargaanController@tarunajson')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna,poliklinik']);
Route::post('/tambah-catatanpenghargaan', 'CatatanPenghargaanController@store')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::post('/edit-catatanpenghargaan', 'CatatanPenghargaanController@update')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/hapus-catatanpenghargaan/{id}', 'CatatanPenghargaanController@destroy')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/penghargaantarunaexport', 'CatatanPenghargaanController@export')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/sertifikat-penghargaan/{id}', 'CatatanPenghargaanController@sertifikatPenghargaan')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);

Route::get('/catatansakit', 'CatatanSakitController@index')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna,poliklinik']);
Route::post('/tambah-catatansakit', 'CatatanSakitController@store')->middleware(['checkRole:pengasuh,admin,pusbangkar,poliklinik']);
Route::post('/edit-catatansakit', 'CatatanSakitController@update')->middleware(['checkRole:pengasuh,admin,pusbangkar,poliklinik']);
Route::get('/hapus-catatansakit/{id}', 'CatatanSakitController@destroy')->middleware(['checkRole:pengasuh,admin,pusbangkar,poliklinik']);

Route::get('/catatanperizinan', 'CatatanPerizinanController@index')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::post('/tambah-catatanperizinan', 'CatatanPerizinanController@store');
Route::post('/edit-catatanperizinan', 'CatatanPerizinanController@update')->middleware(['checkRole:pengasuh,admin']);
Route::get('/hapus-catatanperizinan/{id}', 'CatatanPerizinanController@destroy')->middleware(['checkRole:pengasuh,admin']);

Route::resource('penilaiansamapta', 'PenilaianSamaptaController')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::post('updatepenilaiansamapta', 'PenilaianSamaptaController@update')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/nilaisamaptaexport/{id_semester}', 'PenilaianSamaptaController@export')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/nilaisamaptaexportpdf/{id}', 'PenilaianSamaptaController@exportpdf');
// ->middleware(['checkRole:pengasuh,admin,pusbangkar']);

Route::resource('penilaiansoftskill', 'PenilaianSoftSkillController')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::get('editpenilaiansoftskill/{id}', 'PenilaianSoftSkillController@edit')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::post('updatepenilaiansoftskill', 'PenilaianSoftSkillController@update')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/nilaisoftskillsemesterexport', 'PenilaianSoftSkillController@semesterExport')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/nilaisoftskillexport/{id_mahasiswa}', 'PenilaianSoftSkillController@export')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/nilaisoftskillexportpdf/{id_mahasiswa}/{id_semester}', 'PenilaianSoftSkillController@exportpdf');
// ->middleware(['checkRole:pengasuh,admin,pusbangkar']);

Route::resource('rekapnilai', 'RekapNilaiController')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::post('simpanrekapnilai', 'RekapNilaiController@store')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
 
Route::get('/rapot/{id}', 'RekapNilaiController@rapot')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);
Route::get('/rekapnilaiexport/{id}', 'RekapNilaiController@export')->middleware(['checkRole:pengasuh,admin,pusbangkar']);

Route::get('isikuesioner', 'JawabanKuesionerController@index');
Route::post('tambahisikuesioner', 'JawabanKuesionerController@store');

Route::get('pengajuansurat', 'PengajuanSuratController@index')->middleware(['checkRole:pengasuh,admin,taruna,pusbangkar']);
Route::get('/tambahpengajuansurat', 'PengajuanSuratController@create')->middleware(['checkRole:pengasuh,admin,taruna']);
Route::post('/simpanpengajuansurat', 'PengajuanSuratController@store')->middleware(['checkRole:pengasuh,admin,taruna']);
Route::get('/editpengajuansurat/{id}', 'PengajuanSuratController@edit')->middleware(['checkRole:pengasuh,admin,taruna,pusbangkar']);
Route::post('/updatepengajuansurat', 'PengajuanSuratController@update')->middleware(['checkRole:pengasuh,admin,taruna']);
Route::get('/hapuspengajuansurat/{id}', 'PengajuanSuratController@destroy')->middleware(['checkRole:pengasuh,admin,taruna']);
Route::post('/jawabpengajuan', 'PengajuanSuratController@jawabpengajuan')->middleware(['checkRole:pengasuh,admin,taruna,pusbangkar']);
Route::post('/terbitkansurat', 'PengajuanSuratController@terbitkansurat')->middleware(['checkRole:pusbangkar,admin']);

Route::get('teswa', 'PengajuanSuratController@tesWa');

Route::get('/grupkordinasipengasuh', 'GrupKordinasiPengasuhController@index')->middleware(['checkRole:pengasuh,admin,pusbangkar']);

Route::get('/berita', 'BeritaController@index')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/tambahberita', 'BeritaController@create')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::post('/simpanberita', 'BeritaController@store')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/hapusberita/{id}', 'BeritaController@destroy')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::get('/editberita/{id}', 'BeritaController@edit')->middleware(['checkRole:pengasuh,admin,pusbangkar']);
Route::post('/updateberita', 'BeritaController@update')->middleware(['checkRole:pengasuh,admin,pusbangkar']);

Route::post('/changepassword', 'Auth\ResetPasswordController@changepassword')->middleware(['checkRole:pengasuh,admin,pusbangkar,taruna']);