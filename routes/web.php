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
    return view('operator.dashboard');
});

Route::get('/verification', function () {
    return view('operator.verification');
});

Route::get('/dashboardMahasiswa', function () {
    return view('mahasiswa.dashboard');
});

Route::get('/editprofilMahasiswa', function () {
    return view('mahasiswa.edit-profile');
});