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


Route::get('/login', function () {
    return view('login');
});

Route::get('/signin', function () {
    return view('signin');
});

//mahasiswa
Route::get('/', function () {
    return view('mahasiswa.dashboard');
});

Route::get('/dashboardMahasiswa', function () {
    return view('mahasiswa.dashboard');
});

Route::get('/irs', function () {
    return view('mahasiswa.irs');
});

Route::get('/tambahIrs', function () {
    return view('mahasiswa.irs-create');
});

Route::get('/khs', function () {
    return view('mahasiswa.khs');
});

Route::get('/tambahKhs', function () {
    return view('mahasiswa.khs-create');
});

Route::get('/pkl', function () {
    return view('mahasiswa.pkl');
});

Route::get('/tambahPkl', function () {
    return view('mahasiswa.pkl-create');
});

Route::get('/skripsi', function () {
    return view('mahasiswa.skripsi');
});

Route::get('/tambahSkripsi', function () {
    return view('mahasiswa.skripsi-create');
});

Route::get('/profilMahasiswa', function () {
    return view('mahasiswa.profil');
});

Route::get('/editprofilMahasiswa', function () {
    return view('mahasiswa.profil-edit');
});




// OPERATOR
Route::get('/dashboardOperator', function () {
    return view('operator.dashboard');
});

Route::get('/mahasiswa', function () {
    return view('operator.mahasiswa');
});

Route::get('/profilOperator', function () {
    return view('operator.profil');
});

Route::get('/editprofilOperator', function () {
    return view('operator.profil-edit');
});




//doswal
Route::get('/dashboardDoswal', function () {
    return view('doswal.dashboard');
});

Route::get('/perwalian', function () {
    return view('doswal.perwalian');
});

Route::get('/details', function () {
    return view('doswal.details');
});

Route::get('/profildoswal', function () {
    return view('doswal.editprofil');
});

Route::get('/verification', function () {
    return view('doswal.verification');
});

Route::get('/listpkl', function () {
    return view('doswal.listpkl');
});

Route::get('/listskripsi', function () {
    return view('doswal.listskripsi');
});

Route::get('/rekappkl', function () {
    return view('doswal.rekappkl');
});

Route::get('/rekapskripsi', function () {
    return view('doswal.rekapskripsi');
});