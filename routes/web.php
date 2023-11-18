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

Route::get('/editprofilMahasiswa', function () {
    return view('mahasiswa.edit-profil');
});

//operator
Route::get('/dashboardOperator', function () {
    return view('operator.dashboard');
});

Route::get('/mahasiswa', function () {
    return view('operator.mahasiswa');
});

Route::get('/profilOperator', function () {
    return view('operator.editprofil');
});

Route::get('/verification', function () {
    return view('operator.verification');
});
