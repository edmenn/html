<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\LocalidadesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PresupuestosController;
use App\Http\Controllers\Proyectos\ProyectosController;
use App\Http\Controllers\Proyectos\CancelacionesProyectosController;
use App\Http\Controllers\Proyectos\ComentariosProyectosController;
use App\Http\Controllers\Proyectos\DocumentosProyectosController;
use App\Http\Controllers\Subproyectos\SubproyectosController;
use App\Http\Controllers\Subproyectos\CancelacionesSubproyectosController;
use App\Http\Controllers\Subproyectos\ComentariosSubproyectosController;
use App\Http\Controllers\Subproyectos\DocumentosSubproyectosController;

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
    
    Route::get('cancelacionesproyectos/{proyecto}', [CancelacionesProyectosController::class, 'index'])->name('cancelacionesproyectos.index');
    Route::get('cancelacionesproyectos/{proyecto}/create', [CancelacionesProyectosController::class, 'create'])->name('cancelacionesproyectos.create');
    Route::post('cancelacionesproyectos/{proyecto}/create', [CancelacionesProyectosController::class, 'store'])->name('cancelacionesproyectos.store');
    Route::get('cancelacionesproyectos/{proyecto}/{id}/edit', [CancelacionesProyectosController::class, 'edit'])->name('cancelacionesproyectos.edit');
    Route::put('cancelacionesproyectos/{proyecto}/{id}/edit', [CancelacionesProyectosController::class, 'update'])->name('cancelacionesproyectos.update');
    Route::delete('cancelacionesproyectos/{proyecto}/{id}', [CancelacionesProyectosController::class, 'destroy'])->name('cancelacionesproyectos.destroy');

    Route::get('comentariosproyectos/{proyecto}', [ComentariosProyectosController::class, 'index'])->name('comentariosproyectos.index');
    Route::get('comentariosproyectos/{proyecto}/create', [ComentariosProyectosController::class, 'create'])->name('comentariosproyectos.create');
    Route::post('comentariosproyectos/{proyecto}/create', [ComentariosProyectosController::class, 'store'])->name('comentariosproyectos.store');
    Route::get('comentariosproyectos/{proyecto}/{id}/edit', [ComentariosProyectosController::class, 'edit'])->name('comentariosproyectos.edit');
    Route::put('comentariosproyectos/{proyecto}/{id}/edit', [ComentariosProyectosController::class, 'update'])->name('comentariosproyectos.update');
    Route::delete('comentariosproyectos/{proyecto}/{id}', [ComentariosProyectosController::class, 'destroy'])->name('comentariosproyectos.destroy');

    Route::get('documentosproyectos/{proyecto}', [DocumentosProyectosController::class, 'index'])->name('documentosproyectos.index');
    Route::get('documentosproyectos/{proyecto}/create', [DocumentosProyectosController::class, 'create'])->name('documentosproyectos.create');
    Route::post('documentosproyectos/{proyecto}/create', [DocumentosProyectosController::class, 'store'])->name('documentosproyectos.store');
    Route::delete('documentosproyectos/{proyecto}/{id}', [DocumentosProyectosController::class, 'destroy'])->name('documentosproyectos.destroy');
    
    Route::get('comentariossubproyectos/{subproyecto}', [ComentariosSubproyectosController::class, 'index'])->name('comentariossubproyectos.index');
    Route::get('comentariossubproyectos/{subproyecto}/create', [ComentariosSubproyectosController::class, 'create'])->name('comentariossubproyectos.create');
    Route::post('comentariossubproyectos/{subproyecto}/create', [ComentariosSubproyectosController::class, 'store'])->name('comentariossubproyectos.store');
    Route::get('comentariossubproyectos/{subproyecto}/{id}/edit', [ComentariosSubproyectosController::class, 'edit'])->name('comentariossubproyectos.edit');
    Route::put('comentariossubproyectos/{subproyecto}/{id}/edit', [ComentariosSubproyectosController::class, 'update'])->name('comentariossubproyectos.update');
    Route::delete('comentariossubproyectos/{subproyecto}/{id}', [ComentariosSubproyectosController::class, 'destroy'])->name('comentariossubproyectos.destroy');

    Route::get('cancelacionessubproyectos/{subproyecto}', [CancelacionesSubproyectosController::class, 'index'])->name('cancelacionessubproyectos.index');
    Route::get('cancelacionessubproyectos/{subproyecto}/create', [CancelacionesSubproyectosController::class, 'create'])->name('cancelacionessubproyectos.create');
    Route::post('cancelacionessubproyectos/{subproyecto}/create', [CancelacionesSubproyectosController::class, 'store'])->name('cancelacionessubproyectos.store');
    Route::get('cancelacionessubproyectos/{subproyecto}/{id}/edit', [CancelacionesSubproyectosController::class, 'edit'])->name('cancelacionessubproyectos.edit');
    Route::put('cancelacionessubproyectos/{subproyecto}/{id}/edit', [CancelacionesSubproyectosController::class, 'update'])->name('cancelacionessubproyectos.update');
    Route::delete('cancelacionessubproyectos/{subproyecto}/{id}', [CancelacionesSubproyectosController::class, 'destroy'])->name('cancelacionessubproyectos.destroy');

    Route::get('documentossubproyectos/{subproyecto}', [DocumentosSubproyectosController::class, 'index'])->name('documentossubproyectos.index');
    Route::get('documentossubproyectos/{subproyecto}/create', [DocumentosSubproyectosController::class, 'create'])->name('documentossubproyectos.create');
    Route::post('documentossubproyectos/{subproyecto}/create', [DocumentosSubproyectosController::class, 'store'])->name('documentossubproyectos.store');
    Route::delete('documentossubproyectos/{subproyecto}/{id}', [DocumentosSubproyectosController::class, 'destroy'])->name('documentossubproyectos.destroy');
    
    Route::post('/ultimoCodigo', [PresupuestosController::class, 'ultimoCodigo'])->name('ultimoCodigo');
});