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
use App\Http\Controllers\Proyectos\LicitacionesProyectosController;
use App\Http\Controllers\Proyectos\DocumentosProyectosController;
use App\Http\Controllers\Proyectos\DocumentosLicitacionesProyectosController;
use App\Http\Controllers\Subproyectos\SubproyectosController;
use App\Http\Controllers\Subproyectos\CancelacionesSubproyectosController;
use App\Http\Controllers\Subproyectos\ComentariosSubproyectosController;
use App\Http\Controllers\Subproyectos\LicitacionesSubproyectosController;
use App\Http\Controllers\Subproyectos\DocumentosSubproyectosController;
use App\Http\Controllers\Subproyectos\DocumentosLicitacionesSubproyectosController;

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
    
    Route::get('cancelacionesproyectos/{proyecto}', [CancelacionesProyectosController::class, 'index'])->name('proyectos.cancelaciones.index');
    Route::get('cancelacionesproyectos/{proyecto}/create', [CancelacionesProyectosController::class, 'create'])->name('proyectos.cancelaciones.create');
    Route::post('cancelacionesproyectos/{proyecto}/create', [CancelacionesProyectosController::class, 'store'])->name('proyectos.cancelaciones.store');
    Route::get('cancelacionesproyectos/{proyecto}/{id}/edit', [CancelacionesProyectosController::class, 'edit'])->name('proyectos.cancelaciones.edit');
    Route::put('cancelacionesproyectos/{proyecto}/{id}/edit', [CancelacionesProyectosController::class, 'update'])->name('proyectos.cancelaciones.update');
    Route::delete('cancelacionesproyectos/{proyecto}/{id}', [CancelacionesProyectosController::class, 'destroy'])->name('proyectos.cancelaciones.destroy');

    Route::get('comentariosproyectos/{proyecto}', [ComentariosProyectosController::class, 'index'])->name('proyectos.comentarios.index');
    Route::get('comentariosproyectos/{proyecto}/create', [ComentariosProyectosController::class, 'create'])->name('proyectos.comentarios.create');
    Route::post('comentariosproyectos/{proyecto}/create', [ComentariosProyectosController::class, 'store'])->name('proyectos.comentarios.store');
    Route::get('comentariosproyectos/{proyecto}/{id}/edit', [ComentariosProyectosController::class, 'edit'])->name('proyectos.comentarios.edit');
    Route::put('comentariosproyectos/{proyecto}/{id}/edit', [ComentariosProyectosController::class, 'update'])->name('proyectos.comentarios.update');
    Route::delete('comentariosproyectos/{proyecto}/{id}', [ComentariosProyectosController::class, 'destroy'])->name('proyectos.comentarios.destroy');

    Route::get('licitacionesproyectos/{proyecto}', [LicitacionesProyectosController::class, 'index'])->name('proyectos.licitaciones.index');
    Route::get('licitacionesproyectos/{proyecto}/create', [LicitacionesProyectosController::class, 'create'])->name('proyectos.licitaciones.create');
    Route::post('licitacionesproyectos/{proyecto}/create', [LicitacionesProyectosController::class, 'store'])->name('proyectos.licitaciones.store');
    Route::get('licitacionesproyectos/{proyecto}/{id}/edit', [LicitacionesProyectosController::class, 'edit'])->name('proyectos.licitaciones.edit');
    Route::put('licitacionesproyectos/{proyecto}/{id}/edit', [LicitacionesProyectosController::class, 'update'])->name('proyectos.licitaciones.update');
    Route::delete('licitacionesproyectos/{proyecto}/{id}', [LicitacionesProyectosController::class, 'destroy'])->name('proyectos.licitaciones.destroy');

    Route::get('documentosproyectos/{proyecto}', [DocumentosProyectosController::class, 'index'])->name('proyectos.documentos.index');
    Route::get('documentosproyectos/{proyecto}/create', [DocumentosProyectosController::class, 'create'])->name('proyectos.documentos.create');
    Route::post('documentosproyectos/{proyecto}/create', [DocumentosProyectosController::class, 'store'])->name('proyectos.documentos.store');
    Route::delete('documentosproyectos/{proyecto}/{id}', [DocumentosProyectosController::class, 'destroy'])->name('proyectos.documentos.destroy');

    Route::get('documentoslicitacionesproyectos/{licitacion}', [DocumentosLicitacionesProyectosController::class, 'index'])->name('proyectos.documentoslicitaciones.index');
    Route::get('documentoslicitacionesproyectos/{licitacion}/create', [DocumentosLicitacionesProyectosController::class, 'create'])->name('proyectos.documentoslicitaciones.create');
    Route::post('documentoslicitacionesproyectos/{licitacion}/create', [DocumentosLicitacionesProyectosController::class, 'store'])->name('proyectos.documentoslicitaciones.store');
    Route::delete('documentoslicitacionesproyectos/{licitacion}/{id}', [DocumentosLicitacionesProyectosController::class, 'destroy'])->name('proyectos.documentos.destroy');

    Route::get('cancelacionessubproyectos/{subproyecto}', [CancelacionesSubproyectosController::class, 'index'])->name('subproyectos.cancelaciones.index');
    Route::get('cancelacionessubproyectos/{subproyecto}/create', [CancelacionesSubproyectosController::class, 'create'])->name('subproyectos.cancelaciones.create');
    Route::post('cancelacionessubproyectos/{subproyecto}/create', [CancelacionesSubproyectosController::class, 'store'])->name('subproyectos.cancelaciones.store');
    Route::get('cancelacionessubproyectos/{subproyecto}/{id}/edit', [CancelacionesSubproyectosController::class, 'edit'])->name('subproyectos.cancelaciones.edit');
    Route::put('cancelacionessubproyectos/{subproyecto}/{id}/edit', [CancelacionesSubproyectosController::class, 'update'])->name('subproyectos.cancelaciones.update');
    Route::delete('cancelacionessubproyectos/{subproyecto}/{id}', [CancelacionesSubproyectosController::class, 'destroy'])->name('subproyectos.cancelaciones.destroy');
    
    Route::get('comentariossubproyectos/{subproyecto}', [ComentariosSubproyectosController::class, 'index'])->name('subproyectos.comentarios.index');
    Route::get('comentariossubproyectos/{subproyecto}/create', [ComentariosSubproyectosController::class, 'create'])->name('subproyectos.comentarios.create');
    Route::post('comentariossubproyectos/{subproyecto}/create', [ComentariosSubproyectosController::class, 'store'])->name('subproyectos.comentarios.store');
    Route::get('comentariossubproyectos/{subproyecto}/{id}/edit', [ComentariosSubproyectosController::class, 'edit'])->name('subproyectos.comentarios.edit');
    Route::put('comentariossubproyectos/{subproyecto}/{id}/edit', [ComentariosSubproyectosController::class, 'update'])->name('subproyectos.comentarios.update');
    Route::delete('comentariossubproyectos/{subproyecto}/{id}', [ComentariosSubproyectosController::class, 'destroy'])->name('subproyectos.comentarios.destroy');

    Route::get('licitacionessubproyectos/{subproyecto}', [LicitacionesSubproyectosController::class, 'index'])->name('subproyectos.licitaciones.index');
    Route::get('licitacionessubproyectos/{subproyecto}/create', [LicitacionesSubproyectosController::class, 'create'])->name('subproyectos.licitaciones.create');
    Route::post('licitacionessubproyectos/{subproyecto}/create', [LicitacionesSubproyectosController::class, 'store'])->name('subproyectos.licitaciones.store');
    Route::get('licitacionessubproyectos/{subproyecto}/{id}/edit', [LicitacionesSubproyectosController::class, 'edit'])->name('subproyectos.licitaciones.edit');
    Route::put('licitacionessubproyectos/{subproyecto}/{id}/edit', [LicitacionesSubproyectosController::class, 'update'])->name('subproyectos.licitaciones.update');
    Route::delete('licitacionessubproyectos/{subproyecto}/{id}', [LicitacionesSubproyectosController::class, 'destroy'])->name('subproyectos.licitaciones.destroy');

    Route::get('documentossubproyectos/{subproyecto}', [DocumentosSubproyectosController::class, 'index'])->name('subproyectos.documentos.index');
    Route::get('documentossubproyectos/{subproyecto}/create', [DocumentosSubproyectosController::class, 'create'])->name('subproyectos.documentos.create');
    Route::post('documentossubproyectos/{subproyecto}/create', [DocumentosSubproyectosController::class, 'store'])->name('subproyectos.documentos.store');
    Route::delete('documentossubproyectos/{subproyecto}/{id}', [DocumentosSubproyectosController::class, 'destroy'])->name('subproyectos.documentos.destroy');

    Route::get('documentoslicitacionessubproyectos/{licitacion}', [DocumentosLicitacionesSubproyectosController::class, 'index'])->name('subproyectos.documentoslicitaciones.index');
    Route::get('documentoslicitacionessubproyectos/{licitacion}/create', [DocumentosLicitacionesSubproyectosController::class, 'create'])->name('subproyectos.documentoslicitaciones.create');
    Route::post('documentoslicitacionessubproyectos/{licitacion}/create', [DocumentosLicitacionesSubproyectosController::class, 'store'])->name('subproyectos.documentoslicitaciones.store');
    Route::delete('documentoslicitacionessubproyectos/{licitacion}/{id}', [DocumentosLicitacionesSubproyectosController::class, 'destroy'])->name('subproyectos.documentos.destroy');
    
    Route::post('/ultimoCodigo', [PresupuestosController::class, 'ultimoCodigo'])->name('ultimoCodigo');
});