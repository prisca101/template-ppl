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

Route::get('/', function () {
    return view('mahasiswa.dashboard');
});

Route::get('/verification', function () {
    return view('operator.verification');
});

Route::get('/dashboardMahasiswa', function () {
    return view('mahasiswa.dashboard');
});

Route::get('/irs', function () {
    return view('mahasiswa.irs');
});

Route::get('/khs', function () {
    return view('mahasiswa.khs');
});

Route::get('/dashboardOperator', function () {
    return view('operator.dashboard');
});

Route::get('/editprofilMahasiswa', function () {
    return view('mahasiswa.edit-profil');
});