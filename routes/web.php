<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\LocalidadesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PresupuestosController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\SubproyectosController;
use App\Http\Controllers\CancelacionesController;

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
    Route::resource('localidades', LocalidadesController::class);
    Route::resource('users', UsersController::class);
    
    Route::resource('presupuestos', PresupuestosController::class);
    Route::get('presupuestos/{presupuesto}/editEstado', [PresupuestosController::class, 'editEstado'])->name('presupuestos.editEstado');
    Route::put('presupuestos/{presupuesto}/editEstado', [PresupuestosController::class, 'updateEstado'])->name('presupuestos.updateEstado');
    
    Route::resource('presupuestos.proyectos', ProyectosController::class);
    Route::get('presupuestos/{presupuesto}/proyectos/{id}/editEstado', [ProyectosController::class, 'editEstado'])->name('presupuestos.proyectos.editEstado');
    Route::put('presupuestos/{presupuesto}/proyectos/{id}/editEstado', [ProyectosController::class, 'updateEstado'])->name('presupuestos.proyectos.update-estado');
    
    Route::resource('proyectos.subproyectos', SubproyectosController::class);
    Route::get('proyectos/{proyecto}/subproyectos/{id}/editEstado', [SubproyectosController::class, 'editEstado'])->name('proyectos.subproyectos.editEstado');
    Route::put('proyectos/{proyecto}/subproyectos/{id}/editEstado', [SubproyectosController::class, 'updateEstado'])->name('proyectos.subproyectos.updateEstado');
    
    Route::get('cancelaciones/{tipo}/{id}', [CancelacionesController::class, 'index'])->name('cancelaciones.index');
    Route::get('cancelaciones/{tipo}/{id}/create', [CancelacionesController::class, 'create'])->name('cancelaciones.create');
    Route::post('cancelaciones/{tipo}/{id}/create', [CancelacionesController::class, 'store'])->name('cancelaciones.store');
    Route::get('cancelaciones/{tipo}/{id}/edit', [CancelacionesController::class, 'edit'])->name('cancelaciones.edit');
    Route::put('cancelaciones/{tipo}/{id}/edit', [CancelacionesController::class, 'update'])->name('cancelaciones.update');
    Route::delete('cancelaciones/{tipo}/{id}', [CancelacionesController::class, 'destroy'])->name('cancelaciones.destroy');
    
    Route::post('/ultimoCodigo', [PresupuestosController::class, 'ultimoCodigo'])->name('ultimoCodigo');
});