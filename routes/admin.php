<?php

use App\Http\Controllers\Admin\AspekKriteriaController;
use App\Http\Controllers\Admin\DepartementController;
use App\Http\Controllers\Admin\GapController;
use App\Http\Controllers\Admin\KategoriPenilaianController;
use App\Http\Controllers\Admin\KriteriaPenilaianController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\KeputusanController;
use App\Http\Controllers\PenilaianController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {

    // Router Gap
    Route::group(['prefix' => 'gap', 'as' => "Gap."], function () {
        Route::controller(GapController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/departement', 'create')->name('create');
            Route::get('/edit-data/departement', 'edit')->name('edit');
            Route::get('/detail-data/departement', 'show')->name('show');
            Route::post('/store-data/departement', 'store')->name('store');
            Route::put('/update-data/departement', 'update')->name('update');
            Route::delete('/hapus-data/departement', 'destroy')->name('destroy');
        });
    });
    // Router Departement
    Route::group(['prefix' => 'departement', 'as' => "Departement."], function () {
        Route::controller(DepartementController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/departement', 'create')->name('create');
            Route::get('/edit-data/departement', 'edit')->name('edit');
            Route::get('/detail-data/departement', 'show')->name('show');
            Route::post('/store-data/departement', 'store')->name('store');
            Route::put('/update-data/departement', 'update')->name('update');
            Route::delete('/hapus-data/departement', 'destroy')->name('destroy');
        });
    });

     //
     Route::group(['prefix' => 'staff', 'as' => "Staff."], function () {
        Route::controller(StaffController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail-staff', 'show')->name('show');
            Route::get('/tambah-data-staff', 'create')->name('create');
            Route::get('/edit-data-staff', 'edit')->middleware(['auth', 'password.confirm'])->name('edit');
            Route::post('/store-data-staff', 'store')->name('store');
            Route::put('/update-data-staff', 'update')->name('update');
            Route::delete('/hapus-data-staff', 'destroy')->name('destroy');

            // reset password

            Route::get('/reset-password-staff', 'resetpassword')->middleware(['auth', 'password.confirm'])->name('reset.password');
            Route::post('/reset-password-staff', 'resetpasswordUpdate')->name('reset.password');
        });
    });

    // Router aspek
    Route::group(['prefix' => 'aspek', 'as' => "Aspek."], function () {
        Route::controller(AspekKriteriaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/aspek', 'create')->name('create');
            Route::get('/edit-data/aspek', 'edit')->name('edit');
            Route::get('/detail-data/aspek', 'show')->name('show');
            Route::post('/store-data/aspek', 'store')->name('store');
            Route::put('/update-data/aspek', 'update')->name('update');
            Route::delete('/hapus-data/aspek', 'destroy')->name('destroy');
        });
    });

    //router kriteria
    Route::group(['prefix' => 'kriteria', 'as' => "Kriteria."], function () {
        Route::controller(KriteriaPenilaianController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/kriteria', 'create')->name('create');
            Route::get('/edit-data/kriteria', 'edit')->name('edit');
            Route::get('/detail-data/kriteria', 'show')->name('show');
            Route::post('/store-data/kriteria', 'store')->name('store');
            Route::put('/update-data/kriteria', 'update')->name('update');
            Route::delete('/hapus-data/kriteria', 'destroy')->name('destroy');
        });
    });


    //router kategori
    Route::group(['prefix' => 'kategori', 'as' => "Kategori."], function () {
        Route::controller(KategoriPenilaianController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/kategori', 'create')->name('create');
            Route::get('/edit-data/kategori', 'edit')->name('edit');
            Route::get('/detail-data/kategori', 'show')->name('show');
            Route::post('/store-data/kategori', 'store')->name('store');
            Route::put('/update-data/kategori', 'update')->name('update');
            Route::delete('/hapus-data/kategori', 'destroy')->name('destroy');
        });
    });

    Route::get('riwayat', [PenilaianController::class, 'riwayat'])->name('admin.riwayat.penilaian');
    Route::get('riwayat/detail', [PenilaianController::class, 'riwayat_show'])->name('admin.riwayat.show');


    //router putusan
    Route::group(['prefix' => 'putusan', 'as' => "Keputusan."], function () {
        Route::controller(KeputusanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/putusan', 'create')->name('create');
            Route::get('/edit-data/putusan', 'edit')->name('edit');
            Route::get('/detail-data/putusan', 'show')->name('show');
            Route::post('/store-data/putusan', 'store')->name('store');
            Route::put('/update-data/putusan', 'update')->name('update');
            Route::delete('/hapus-data/putusan', 'destroy')->name('destroy');
        });
    });
});
