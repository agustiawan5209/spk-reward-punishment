<?php

use App\Http\Controllers\Api\StaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('list/staff/{departement_id}', [StaffController::class,'getStaff'])->name('api.staff.list');
Route::get('reward/staff/', [StaffController::class,'getRewardStaff'])->name('api.staff.reward');
Route::get('punishment/staff/', [StaffController::class,'getPunishmentStaff'])->name('api.staff.punishment');
