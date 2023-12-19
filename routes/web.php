<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\PKLController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\DashboardOperatorController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDepartemenController;
use App\Http\Controllers\VerifikasiController;
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
    return view('login');
})->middleware('auth');

Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticate']);

Route::controller(AuthController::class)->middleware('auth')->group(function(){
    Route::get('logout', 'logout')->name('logout');
});

// otw pengubahan

Route::get('dashboardMahasiswa', [DashboardMahasiswaController::class,'dashboardMahasiswa'])->middleware(['auth','only_mahasiswa','verified'])->name('dashboardMahasiswa');
Route::get('dashboardDosen', [DashboardDosenController::class,'dashboardDosen'])->middleware(['auth','only_dosen'])->name('dashboardDosen');
Route::get('/searchMahasiswa', [DashboardDosenController::class,'searchMahasiswa'])->middleware(['auth','only_dosen'])->name('searchMhs');
Route::get('dashboardDepartemen', [DashboardDepartemenController::class,'dashboardDepartemen'])->middleware(['auth','only_departemen'])->name('dashboardDepartemen');
Route::get('daftar_akun', [UserController::class,'daftar_akun'])->middleware(['auth','only_operator']);

Route::middleware(['auth', 'only_operator'])->group(function () {
    Route::get('dashboardOperator', [DashboardOperatorController::class, 'dashboardOperator'])->name('dashboardOperator');
    Route::get('/mahasiswa', [DashboardOperatorController::class, 'mahasiswa'])->name('mahasiswa');
    Route::get('/mahasiswa-add', [DashboardOperatorController::class, 'mahasiswa'])->name('create');
    Route::post('/mahasiswa', [DashboardOperatorController::class, 'store'])->name('store');
    Route::get('/searchOperator', [DashboardOperatorController::class, 'searchOperator'])->name('search');
    Route::get('/rekap', [DashboardOperatorController::class, 'rekap'])->name('rekap');
    Route::get('/profilOperator', [OperatorController::class, 'edit'])->name('edit3');
    Route::get('/profilOperator-edit', [OperatorController::class, 'showEdit'])->name('showEdit3');
    Route::post('/profilOperator-edit', [OperatorController::class, 'update'])->name('update3');
    Route::get('/mhs/{nim}', [DashboardOperatorController::class,'mhs'])->name('mhs');
    Route::delete('/mahasiswa/{nim_mahasiswa}', [DashboardOperatorController::class,'deleteMahasiswa'])->name('delete');
    Route::get('/importMahasiswa',[OperatorController::class,'tambah']);
    Route::get('/editMahasiswa/{nim}', [OperatorController::class, 'editMahasiswa'])->name('mahasiswa.edit.get');
    Route::post('/editMahasiswa/{nim}',[OperatorController::class,'editMahasiswa'])->name('mahasiswa.edit');
    Route::post('/importMahasiswa-import',[OperatorController::class,'import'])->name('mahasiswa.import');
    Route::get('/mahasiswa/preview', [OperatorController::class, 'preview'])->name('mahasiswa.preview');
    Route::post('/generateAkun',[OperatorController::class,'generateAkun'])->name('generateAkun');
    Route::get('/export', [OperatorController::class,'export'])->name('export');
    Route::get('/detailsMhs/{nim}', [OperatorController::class,'dataMahasiswa'])->name('dataMahasiswa');
    Route::get('/downloadRekapPKL', [DashboardOperatorController::class,'downloadRekapPKL'])->name('downloadRekapPKL');
    Route::get('/downloadRekapSkripsi', [DashboardOperatorController::class,'downloadRekapSkripsi'])->name('downloadRekapSkripsi');
    Route::get('/downloadRekapStatus', [DashboardOperatorController::class,'downloadRekapStatus'])->name('downloadRekapStatus');
    Route::get('/pkllulus/{angkatan}/{status}', [OperatorController::class, 'pkllulus'])->name('pkllulus');
    Route::get('/pkltidaklulus/{angkatan}/{status}', [OperatorController::class, 'pkltidaklulus'])->name('pkltidaklulus');
    Route::get('/skripsilulus/{angkatan}/{status}', [OperatorController::class, 'skripsilulus'])->name('skripsilulus');
    Route::get('/skripsitidaklulus/{angkatan}/{status}', [OperatorController::class, 'skripsitidaklulus'])->name('skripsitidaklulus');
    Route::get('/daftarstatus/{angkatan}/{status}', [OperatorController::class, 'daftarstatus'])->name('daftarstatus');
    Route::get('/PreviewListPKLLulusOperator/{angkatan}/{status}', [OperatorController::class, 'PreviewListPKLLulus'])->name('OperatorListPKLLulus');
    Route::get('/PreviewListPKLTidakLulusOperator/{angkatan}/{status}', [OperatorController::class, 'PreviewListPKLBelum'])->name('OperatorListPKLTidakLulus');
    Route::get('/PreviewListSkripsiLulusOperator/{angkatan}/{status}', [OperatorController::class, 'PreviewListSkripsiLulus'])->name('OperatorListSkripsiLulus');
    Route::get('/PreviewListSkripsiTidakLulusOperator/{angkatan}/{status}', [OperatorController::class, 'PreviewListSkripsiBelum'])->name('OperatorListSkripsiTidakLLulus');
    Route::get('/PreviewListStatusOperator/{angkatan}/{status}', [OperatorController::class, 'PreviewListStatus'])->name('OperatorListStatus');
});

Route::middleware(['auth', 'only_dosen'])->group(function () {
    Route::get('/perwalian', [DosenController::class, 'detail'])->name('perwalian');
    Route::get('/details/{nim}', [DosenController::class, 'dataMahasiswa'])->name('details');
    Route::get('/search', [DosenController::class, 'searchMhs'])->name('searchmhs');
    Route::get('/profilDosen', [DosenController::class, 'edit'])->name('edit4');
    Route::get('/profilDosen-edit', [DosenController::class, 'showEdit'])->name('showEdit4');
    Route::post('/profilDosen-edit', [DosenController::class, 'update'])->name('update4');
    Route::get('/RekapPKL',[DosenController::class,'RekapPKL'])->name('RekapPKL');
    Route::get('/RekapSkripsi',[DosenController::class,'RekapSkripsi'])->name('RekapSkripsi');
    Route::get('/RekapStatus',[DosenController::class,'RekapStatus'])->name('RekapStatus');
    Route::get('/DoswalPreviewStatus',[DosenController::class,'DoswalPreviewStatus'])->name('DoswalPreviewStatus');
    Route::get('/daftarstatusdoswal/{angkatan}/{status}',[DosenController::class,'daftarstatus'])->name('daftarstatusdoswal');
    Route::get('/PreviewListStatus/{angkatan}/{status}',[DosenController::class,'PreviewListStatus'])->name('PreviewListStatusDoswal');
});

Route::controller(ListController::class)->middleware(['auth', 'only_departemen'])->group(function () {
    Route::get('/listMahasiswa/{angkatan}/{status}', 'index')->name('list.index');
    Route::get('/listMahasiswaSkripsi/{angkatan}/{status}', 'skripsi')->name('list.skripsi');
    Route::get('/listMahasiswa2/{angkatan}/{status}', 'index2')->name('list.index2'); //tidak lulus
    Route::get('/listMahasiswaSkripsi2/{angkatan}/{status}', 'skripsi2')->name('list.skripsi2'); //tidak lulus
    Route::get('/daftarstatusdepart/{angkatan}/{status}', 'daftarstatus')->name('daftarstatusdepart'); //tidak lulus
    Route::get('/DownloadListPKLDepartLulus/{angkatan}/{status}','PreviewListPKLLulus')->name('PreviewListPKLLulus');
    Route::get('/DownloadListPKLDepartBelum/{angkatan}/{status}','PreviewListPKLBelum')->name('PreviewListPKLBelum');
    Route::get('/DownloadListSkripsiDepartLulus/{angkatan}/{status}','PreviewListSkripsiLulus')->name('PreviewListSkripsiLulus');
    Route::get('/DownloadListSkripsiBelumDepartemen/{angkatan}/{status}','PreviewListSkripsiBelum')->name('SkripsiBelumDepart');
    Route::get('/DownloadListStatusDepart/{angkatan}/{status}','PreviewListStatus')->name('StatusDepart');
});

Route::controller(DosenController::class)->middleware(['auth', 'only_dosen'])->group(function () {
    Route::get('/PKLLulus/{angkatan}/{status}', 'lulusPKL')->name('lulusPKL');
    Route::get('/SkripsiLulus/{angkatan}/{status}', 'lulusSkripsi')->name('lulusSkripsi');
    Route::get('/PKLBelum/{angkatan}/{status}', 'tidaklulusPKL')->name('tidaklulusPKL'); //tidak lulus
    Route::get('/tidaklulusskripsidoswal/{angkatan}/{status}', 'tidaklulusSkripsi')->name('tidaklulusSkripsi'); //tidak lulus
    Route::get('/DownloadListPKLDoswalLulus/{angkatan}/{status}','DoswalListPKLLulus')->name('DoswalListPKLLulus');
    Route::get('/DownloadListPKLDoswalBelum/{angkatan}/{status}','DoswalListPKLBelum')->name('DoswalListPKLBelum');
    Route::get('/DownloadListSkripsiDoswalulus/{angkatan}/{status}','DoswalListSkripsiLulus')->name('DoswalListSkripsiLulus');
    Route::get('/DownloadListSkripsiDepartBelum/{angkatan}/{status}','DoswalListSkripsiBelum')->name('DoswalListSkripsiBelum');
    Route::get('/DownloadRekapPKLDoswal','DoswalPreviewPKL')->name('DoswalPreviewPKL');
    Route::get('/DownloadRekapSkripsiDoswal','DoswalPreviewSkripsi')->name('DoswalPreviewSkripsi');
    Route::get('/DownloadRekapStatusDoswal','DoswalPreviewStatus')->name('DoswalPreviewStatus');
});

Route::controller(IRSController::class)->middleware(['auth', 'only_mahasiswa','verified'])->group(function () {
    Route::get('/irs', 'index')->name('irs.index');
    Route::get('/tambahIrs', 'create')->name('irs.create');
    Route::post('/irs-store', 'store')->name('irs.store');
    Route::post('/irs-updateStatus', 'status')->name('irs.updateStatus');
    Route::get('/irs/{semester_aktif}', 'getUpdateIrs')->name('irs.getIrs');
    Route::post('irs-update/{semester_aktif}', 'postUpdateIrs')->name('irs.updateIrs');
});

Route::controller(KHSController::class)->middleware(['auth', 'only_mahasiswa','verified'])->group(function () {
    Route::get('/khs', 'index')->name('khs.index');
    Route::get('/tambahKhs', 'create')->name('khs.create');
    Route::post('/khs-store', 'store')->name('khs.store');
    Route::get('/khs/{semester_aktif}', 'getUpdateKhs')->name('khs.getKhs');
    Route::post('khs-update/{semester_aktif}', 'postUpdateKhs')->name('khs.updateKhs');
});

Route::controller(PKLController::class)->middleware(['auth', 'only_mahasiswa','verified'])->group(function () {
    Route::get('/pkl', 'index')->name('pkl.index');
    Route::get('/tambahPkl', 'create')->name('pkl.create');
    Route::post('/pkl-store', 'store')->name('pkl.store');
    Route::get('/pkl/{semester_aktif}', 'getUpdatePkl')->name('pkl.getPkl');
    Route::post('pkl-update/{semester_aktif}', 'postUpdatePkl')->name('pkl.updatePkl');
});

Route::controller(SkripsiController::class)->middleware(['auth', 'only_mahasiswa','verified'])->group(function () {
    Route::get('/skripsi', 'index')->name('skripsi.index');
    Route::get('/tambahSkripsi', 'create')->name('skripsi.create');
    Route::post('/skripsi-store', 'store')->name('skripsi.store');
    Route::get('/skripsi/{semester_aktif}', 'getUpdateSkripsi')->name('skripsi.getSkripsi');
    Route::post('skripsi-update/{semester_aktif}', 'postUpdateSkripsi')->name('skripsi.updateSkripsi');
});

Route::controller(MahasiswaController::class)->middleware(['auth', 'only_mahasiswa'])->group(function () {
    Route::get('/profilMahasiswa','edit')->name('mhs.edit');
    Route::get('/profilMahasiswa-edit','showEdit')->name('mhs.showEdit');
    Route::post('/profilMahasiswa-edit', 'update')->name('mhs.update');
    Route::get('/profilMahasiswa2','edit2')->name('mhs.edit2');
    Route::get('/profilMahasiswa-edit2','showEdit2')->name('mhs.showEdit2');
    Route::post('/profilMahasiswa-edit2', 'update2')->name('mhs.update2');
    Route::get('/editprofilMahasiswa', 'editProfil')->name('mahasiswa.editProfil')->middleware('verified');
    Route::get('/editprofilMahasiswa-show', 'showProfil')->name('mahasiswa.showProfil')->middleware('verified');
    Route::post('/editprofilMahasiswa-show', 'updateProfil')->name('mahasiswa.updateProfil')->middleware('verified');
    
});

Route::controller(VerifikasiController::class)->middleware(['auth','only_dosen'])->group(function () {
    Route::get('/showAllVerifikasi','showAll')->name('showAll');
    Route::post('/verifikasi/{nim}/{semester_aktif}','verifikasi')->name('verifikasi');
    Route::post('/rejected/{nim}/{semester_aktif}','rejected')->name('rejected');

    Route::get('/vieweditIRS/{idirs}','vieweditIRS')->name('vieweditIRS');
    Route::post('/editIRS/{idirs}','editIRS')->name('editIRS');
    Route::get('/vieweditKHS/{idkhs}','vieweditKHS')->name('vieweditKHS');
    Route::post('/editKHS/{idkhs}','editKHS')->name('editKHS');
    Route::get('/vieweditPKL/{idpkl}','vieweditPKL')->name('vieweditPKL');
    Route::post('/editPKL/{idpkl}','editPKL')->name('editPKL');
    Route::get('/vieweditSkripsi/{idskripsi}','vieweditSkripsi')->name('vieweditSkripsi');
    Route::post('/editSkripsi/{idskripsi}','editSkripsi')->name('editSkripsi');

    Route::post('/verifikasiKHS/{nim}/{semester_aktif}','verifikasiKHS')->name('verifikasiKHS');
    Route::post('/rejectedKHS/{nim}/{semester_aktif}','rejectedKHS')->name('rejectedKHS');
    Route::post('/verifikasiPKL/{nim}/{semester_aktif}','verifikasiPKL')->name('verifikasiPKL');
    Route::post('/rejectedPKL/{nim}/{semester_aktif}','rejectedPKL')->name('rejectedPKL');
    Route::post('/verifikasiSkripsi/{nim}/{semester_aktif}','verifikasiSkripsi')->name('verifikasiSkripsi');
    Route::post('/rejectedSkripsi/{nim}/{semester_aktif}','rejectedSkripsi')->name('rejectedSkripsi');
});

Route::controller(DashboardDepartemenController::class)->middleware(['auth','only_departemen'])->group(function(){
    Route::get('/RekapPKLDepartemen','PreviewPKL')->name('rekapPKL');
    Route::get('/RekapSkripsiDepartemen','PreviewSkripsi')->name('rekapSkripsi');
    Route::get('/RekapDepartemen','rekap')->name('rekap');
    Route::get('/RekapStatusDepartemen','downloadRekapStatus')->name('rekapstatusdepart');
    Route::get('/DaftarDetailMahasiswa','mahasiswa')->name('mahasiswadepart');
    Route::get('/SearchDepartemen','searchDepartemen')->name('searchDepartemen');
    Route::get('/DetailsMahasiswa/{nim}','dataMahasiswa')->name('detailMhs');
});

Route::controller(DepartemenController::class)->middleware(['auth','only_departemen'])->group(function (){
    Route::get('/DownloadRekapPKLDepart','PreviewPKL')->name('PreviewPKL');
    Route::get('/DownloadRekapSkripsiDepart','PreviewSkripsi')->name('PreviewSkripsi');
    Route::get('/profilDepartemen', [DepartemenController::class, 'edit'])->name('edit6');
    Route::get('/profilDepartemen-edit', [DepartemenController::class, 'showEdit'])->name('showEdit6');
    Route::post('/profilDepartemen-edit', [DepartemenController::class, 'update'])->name('update');
});


// blm diubah
Route::get('signin', [AuthController::class,'login'])->name('signin');
Route::post('signin', [AuthController::class, 'authenticate']);

