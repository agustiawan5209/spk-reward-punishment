<?php

use App\Http\Controllers\Kepala\StaffController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sekretariat\PenilaianController as SekretariatPenilaianController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/photo-profile', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';

//router penilaian
Route::middleware(['auth', 'verified', 'role:Kepala Bagian|Kepala Sekretariat|Staff'])->group(function () {

    Route::group(['prefix' => 'penilaian', 'as' => "Penilaian."], function () {
        Route::controller(PenilaianController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-data/penilaian', 'create')->name('create');
            Route::get('/edit-data/penilaian', 'edit')->name('edit');
            Route::get('/detail-data/penilaian', 'show')->name('show');
            Route::post('/store-data/penilaian', 'store')->name('store');
            Route::put('/update-data/penilaian', 'update')->name('update');
            Route::delete('/hapus-data/penilaian', 'destroy')->name('destroy');
        });
    });
});

//router Staff Departement Kepala bagian
Route::middleware(['auth', 'verified', 'role:Kepala Bagian'])->group(function () {

    Route::group(['prefix' => 'karyawan', 'as' => "Kepala.staff."], function () {
        Route::controller(StaffController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail-data/karyawan', 'show')->name('show');
        });
    });
});


//router Penilaian Untuk Kepala Sekeretariat
Route::middleware(['auth', 'verified', 'role:Kepala Sekretariat'])->group(function () {

    Route::group(['prefix' => 'penilaian-karyawan', 'as' => "Sekretariat.penilaian."], function () {
        Route::controller(SekretariatPenilaianController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail-data', 'show')->name('show');
        });
    });
});
