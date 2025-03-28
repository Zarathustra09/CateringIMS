<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ReservationController;
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



Route::put('/reservation/{id}', [ReservationController::class, 'update'])->name('api.reservation.update');
Route::get('/reservation', [ReservationController::class, 'index'])->name('api.reservation.index');
Route::get('menus/{id}/showSingle', [MenuController::class, 'showSingle'])->name('api.menus.showSingle');
