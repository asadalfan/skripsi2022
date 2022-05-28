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

Auth::routes();

// Dashboard
Route::get('/home', 'HomeController@index')->name('home');

// Perusahaan
Route::get('/perusahaan', 'PerusahaanController@index');
Route::post('/perusahaan', 'PerusahaanController@store');
Route::post('/perusahaan/update/{id}', 'PerusahaanController@update');
Route::post('/perusahaan/delete/{id}', 'PerusahaanController@destroy');

// Kategori
Route::get('/kategori', 'TagController@index');
Route::post('/kategori', 'TagController@store');
Route::post('/kategori/update/{id}', 'TagController@update');
Route::post('/kategori/delete/{id}', 'TagController@destroy');

// Pekerjaan
Route::get('/pekerjaan', 'PekerjaanController@index');
Route::post('/pekerjaan', 'PekerjaanController@store');
Route::post('/pekerjaan/update/{id}', 'PekerjaanController@update');
Route::post('/pekerjaan/delete/{id}', 'PekerjaanController@destroy');

// Pelamar
Route::get('/pelamar', 'PelamarController@index');
Route::post('/pelamar', 'PelamarController@store');
Route::post('/pelamar/update/{id}', 'PelamarController@update');
Route::post('/pelamar/delete/{id}', 'PelamarController@destroy');

// Lamaran
Route::get('/lamaran', 'LamaranController@index');
Route::post('/lamaran', 'LamaranController@store');
Route::post('/lamaran/update/{id}', 'LamaranController@update');
Route::post('/lamaran/delete/{id}', 'LamaranController@destroy');

// Tes
Route::group(['prefix'=>'tes'], function(){
	// Soal
	Route::get('/soal', 'SoalController@index');
	Route::post('/soal', 'SoalController@store');
	Route::post('/soal/update/{id}', 'SoalController@update');
	Route::post('/soal/delete/{id}', 'SoalController@destroy');

	// Hasil
	Route::get('/hasil', 'SawHasilController@index');
	Route::post('/hasil', 'SawHasilController@store');
	Route::post('/hasil/update/{id}', 'SawHasilController@update');
	Route::post('/hasil/delete/{id}', 'SawHasilController@destroy');

    // Peringkat
    Route::get('/peringkat', 'SawHasilController@showPeringkat');
    Route::get('/peringkat/hitung', 'SawHasilController@hitungPeringkat');
});
