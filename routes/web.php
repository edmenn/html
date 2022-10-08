<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\PuertosController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PresupuestosController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\SubproyectosController;

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

Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'checklogin'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('proveedores', ProveedoresController::class);
    Route::resource('puertos', PuertosController::class);
    Route::resource('users', UsersController::class);
    Route::resource('presupuestos', PresupuestosController::class);
    Route::resource('presupuestos.proyectos', ProyectosController::class);
    Route::resource('proyectos.subproyectos', SubproyectosController::class);
});