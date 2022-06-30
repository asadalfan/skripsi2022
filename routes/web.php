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

Route::middleware(['role:admin,HRD'])->group(function () {
    // Kategori
    Route::get('/kategori', 'TagController@index');
    Route::post('/kategori', 'TagController@store');
    Route::post('/kategori/update/{id}', 'TagController@update');
    Route::post('/kategori/delete/{id}', 'TagController@destroy');
});

Route::middleware(['role:admin,tim-seleksi'])->group(function () {
    // Pekerjaan
    Route::group(['prefix' => 'pekerjaan'], function () {
        // Pekerjaan Verifikasi
        Route::get('/verifikasi', 'PekerjaanController@verifikasi');
        Route::post('/{id}/verified', 'PekerjaanController@verified');
        Route::post('/{id}/unverified', 'PekerjaanController@unverified');
    });
});

Route::middleware(['role:admin'])->group(function () {
    // User
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');
        Route::post('/update/{id}', 'UserController@update');
        Route::post('/delete/{id}', 'UserController@destroy');
    });

    // Perusahaan
    Route::get('/perusahaan', 'PerusahaanController@index');
    Route::post('/perusahaan', 'PerusahaanController@store');
    Route::post('/perusahaan/update/{id}', 'PerusahaanController@update');
    Route::post('/perusahaan/delete/{id}', 'PerusahaanController@destroy');

    // Pekerjaan
    Route::group(['prefix' => 'pekerjaan'], function () {
        Route::get('/', 'PekerjaanController@index');
        Route::post('/', 'PekerjaanController@store');
        Route::post('/update/{id}', 'PekerjaanController@update');
        Route::post('/delete/{id}', 'PekerjaanController@destroy');
    });

    // Pelamar
    Route::get('/pelamar', 'PelamarController@index');
    Route::post('/pelamar', 'PelamarController@store');
    Route::post('/pelamar/update/{id}', 'PelamarController@update');
    Route::post('/pelamar/delete/{id}', 'PelamarController@destroy');

    // Lamaran
    Route::group(['prefix' => 'lamaran'], function () {
        Route::get('/', 'LamaranController@index');
        Route::post('/', 'LamaranController@store');
        Route::post('/update/{id}', 'LamaranController@update');
        Route::post('/delete/{id}', 'LamaranController@destroy');

        // Lamaran Verifikasi
        Route::get('/verifikasi', 'LamaranController@verifikasi');
        Route::post('/{id}/verified', 'LamaranController@verified');
        Route::post('/{id}/unverified', 'LamaranController@unverified');

        // Lamaran Hasil
        Route::get('/hasil', 'LamaranController@hasil');
        Route::post('/{id}/terima', 'LamaranController@terima');
        Route::post('/{id}/tolak', 'LamaranController@tolak');
    });

    // Tes
    Route::group(['prefix' => 'tes'], function () {
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
});

Route::middleware(['role:pelamar'])->group(function () {
    // Profile
    Route::get('/profile', 'Pelamar\PelamarController@showProfile');

    // Pelamar
    Route::post('/pelamar/update/{id}', 'Pelamar\PelamarController@updateProfile');

    Route::group(['namespace' => 'Pelamar', 'prefix' => 'pelamar'], function () {
        // Pekerjaan
        Route::group(['prefix' => 'pekerjaan'], function () {
            Route::get('/', 'PekerjaanController@index');
            Route::post('/lamar', 'LamaranController@store');
        });

        // Lamaran
        Route::group(['prefix' => 'lamaran'], function () {
            Route::get('/', 'LamaranController@index');
            Route::get('/hasil', 'LamaranController@hasil');
        });

        // Tes
        Route::group(['prefix' => 'tes'], function () {
            // Soal
            Route::get('/soal/{kriteria_id}/{lamaran_id}', 'SoalController@index');
            Route::post('/soal/{kriteria_id}/{lamaran_id}/selesai', 'SoalController@selesai');

            // Hasil
            Route::get('/hasil', 'SawHasilController@index');
        });
    });
});

Route::middleware(['role:HRD'])->group(function () {
    Route::group(['namespace' => 'HRD', 'prefix' => 'HRD'], function () {
        // Perusahaan
        Route::get('/perusahaan', 'PerusahaanController@index');
        Route::post('/perusahaan', 'PerusahaanController@storeHRD');
        Route::post('/perusahaan/update/{id}', 'PerusahaanController@updateHRD');
        Route::post('/perusahaan/delete/{id}', 'PerusahaanController@destroyHRD');

        // Pekerjaan
        Route::group(['prefix' => 'pekerjaan'], function () {
            Route::get('/', 'PekerjaanController@index');
            Route::post('/', 'PekerjaanController@storeHRD');
            Route::post('/update/{id}', 'PekerjaanController@updateHRD');
            Route::post('/delete/{id}', 'PekerjaanController@destroyHRD');
        });

        // Lamaran
        Route::group(['prefix' => 'lamaran'], function () {
            Route::get('/', 'LamaranController@index');

            // Lamaran Verifikasi
            Route::get('/verifikasi', 'LamaranController@verifikasi');
            Route::post('/{id}/verified', 'LamaranController@verifiedHRD');
            Route::post('/{id}/unverified', 'LamaranController@unverifiedHRD');

            // Lamaran Hasil
            Route::get('/hasil', 'LamaranController@hasil');
            Route::post('/{id}/terima', 'LamaranController@terimaHRD');
            Route::post('/{id}/tolak', 'LamaranController@tolakHRD');
        });

        // Tes
        Route::group(['prefix' => 'tes'], function () {
            // Soal
            Route::get('/soal', 'SoalController@index');
            Route::post('/soal', 'SoalController@storeHRD');
            Route::post('/soal/update/{id}', 'SoalController@updateHRD');
            Route::post('/soal/delete/{id}', 'SoalController@destroyHRD');

            // Hasil
            Route::get('/hasil', 'SawHasilController@index');
            Route::post('/hasil/update/{id}', 'SawHasilController@updateHRD');

            // Peringkat
            Route::get('/peringkat', 'SawHasilController@showPeringkat');
            Route::get('/peringkat/hitung', 'SawHasilController@hitungPeringkat');
        });
    });
});