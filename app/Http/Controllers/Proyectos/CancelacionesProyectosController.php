<?php

namespace App\Http\Controllers\Proyectos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\CancelacionMonto;
use App\Models\Proyecto;

class CancelacionesProyectosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // PERMISOS PARA ROLES DE ADMINISTRADOR Y JEFE DEPARTAMENTAL 
        // solamente para la funcionalidad show no hace falta permisos
        $this->middleware('verificarRol:administracion,jefe_departamental')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Proyecto $proyecto)
    {
        // obtenemos todas las cancelaciones del proyecto
        $cancelaciones = CancelacionMonto::where('proyecto_id', $proyecto->id)->get();

        // retornamos respuesta
        return view('cancelacionesproyectos.index', compact('proyecto', 'cancelaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Proyecto $proyecto)
    {
        return view('cancelacionesproyectos.create', compact('proyecto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Proyecto $proyecto)
    {
        // validamos los datos enviados
        $rules = array(
            'monto_cancelado' => 'required|integer|max:2147483647',
            'motivo' => 'required|string',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // verificamos que el monto cancelado no sea mayor al monto disponible
        if($proyecto->costo < $request->monto_cancelado){
            $validator->errors()->add('monto_cancelado', 'Monto a cancelar es mayor al monto disponible.'); // Agregamos el error
            return back()->withErrors($validator)->withInput();
        }

        // creamos una nueva cancelacion de monto
        $cancelacion_monto = new CancelacionMonto;
        $cancelacion_monto->proyecto_id = $proyecto->id;
        $cancelacion_monto->monto_cancelado = $request->monto_cancelado;
        $cancelacion_monto->motivo = $request->motivo;
        $cancelacion_monto->save();

        // cancelamos el monto del proyecto
        $proyecto->costo = $proyecto->costo - $cancelacion_monto->monto_cancelado;
        $proyecto->save();

        // retornamos respuesta
        return redirect()->route('cancelacionesproyectos.index', $proyecto->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto, $id)
    {
        // chequeamos que exista el registro de cancelacion
        $cancelacion = CancelacionMonto::findOrFail($id);
        
        // retornamos respuesta
        return response()->json(['proyecto' => $proyecto, 'cancelacion' => $cancelacion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto, $id)
    {
        // chequeamos que exista el registro de cancelacion
        $cancelacion = CancelacionMonto::findOrFail($id);
                
        return view('cancelacionesproyectos.edit', compact('proyecto', 'cancelacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyecto $proyecto, $id)
    {
        // Verificamos que exista el registro de cancelacion
        $cancelacion_monto = CancelacionMonto::findOrFail($id);
        $monto_disponible = $proyecto->costo + $cancelacion_monto->monto_cancelado;

        // validamos los datos enviados
        $rules = array(
            'monto_cancelado' => 'required|integer|max:2147483647',
            'motivo' => 'required|string',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // verificamos que el monto cancelado no sea mayor al monto disponible
        if($monto_disponible < $request->monto_cancelado){
            $validator->errors()->add('monto_cancelado', 'Monto a cancelar es mayor al monto disponible.'); // Agregamos el error
            return back()->withErrors($validator)->withInput();
        }

        // anulamos el monto cancelado del proyecto
        $proyecto->costo = $proyecto->costo + $cancelacion_monto->monto_cancelado;
        $proyecto->save();

        // modificamos el registro de cancelacion
        $cancelacion_monto->monto_cancelado = $request->monto_cancelado;
        $cancelacion_monto->motivo = $request->motivo;
        $cancelacion_monto->save();

        // cancelamos el monto del proyecto
        $proyecto->costo = $proyecto->costo - $cancelacion_monto->monto_cancelado;
        $proyecto->save();

        // retornamos respuesta
        return redirect()->route('cancelacionesproyectos.index', $proyecto->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto, $id)
    {
        // Verificamos que exista el registro de cancelacion
        $cancelacion_monto = CancelacionMonto::findOrFail($id);
        // anulamos el monto cancelado del proyecto
        $proyecto->costo = $proyecto->costo + $cancelacion_monto->monto_cancelado;
        $proyecto->save();

        // eliminamos el registro de cancelacion
        $cancelacion_monto->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Registro de cancelación eliminado correctamente']);
    }

}