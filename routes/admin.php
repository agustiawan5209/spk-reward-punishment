<?php

use App\Http\Controllers\Admin\DepartementController;
use App\Http\Controllers\Admin\StaffController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {

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
});
