<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category.index');
Route::get('/admin/category/{id}', [CategoryController::class, 'show'])->name('admin.category.show');
Route::post('/admin/category', [CategoryController::class, 'store'])->name('admin.category.store');
Route::put('/admin/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
Route::delete('/admin/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
Route::get('/admin/list', [CategoryController::class, 'list'])->name('admin.category.list');


Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory.index');
Route::get('/admin/inventory/{id}', [InventoryController::class, 'show'])->name('admin.inventory.show');
Route::post('/admin/inventory', [InventoryController::class, 'store'])->name('admin.inventory.store');
Route::put('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('admin.inventory.update');
Route::delete('/admin/inventory/{id}', [InventoryController::class, 'destroy'])->name('admin.inventory.destroy');


//admin employee
Route::get('/admin/employee', [EmployeeController::class, 'index'])->name('admin.employee.index');
Route::get('/admin/employee/{id}', [EmployeeController::class, 'show'])->name('admin.employee.show');
Route::post('/admin/employee', [EmployeeController::class, 'store'])->name('admin.employee.store');
Route::put('/admin/employee/{id}', [EmployeeController::class, 'update'])->name('admin.employee.update');
Route::delete('/admin/employee/{id}', [EmployeeController::class, 'destroy'])->name('admin.employee.destroy');


//admin client

Route::get('/admin/client', [ClientController::class, 'index'])->name('admin.client.index');
Route::get('/admin/client/{id}', [ClientController::class, 'show'])->name('admin.client.show');
Route::post('/admin/client', [ClientController::class, 'store'])->name('admin.client.store');
Route::put('/admin/client/{id}', [ClientController::class, 'update'])->name('admin.client.update');
Route::delete('/admin/client/{id}', [ClientController::class, 'destroy'])->name('admin.client.destroy');
