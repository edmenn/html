<?php

namespace App\Http\Controllers\Subproyectos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\CancelacionMonto;
use App\Models\Subproyecto;

class CancelacionesSubproyectosController extends Controller
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
    public function index(Subproyecto $subproyecto)
    {
        // obtenemos todas las cancelaciones del subproyecto
        $cancelaciones = CancelacionMonto::where('subproyecto_id', $subproyecto->id)->get();

        // retornamos respuesta
        return view('subproyectos.cancelaciones.index', compact('subproyecto', 'cancelaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Subproyecto $subproyecto)
    {
        return view('subproyectos.cancelaciones.create', compact('subproyecto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Subproyecto $subproyecto)
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
        if($subproyecto->costo < $request->monto_cancelado){
            $validator->errors()->add('monto_cancelado', 'Monto a cancelar es mayor al monto disponible.'); // Agregamos el error
            return back()->withErrors($validator)->withInput();
        }

        // creamos una nueva cancelacion de monto
        $cancelacion_monto = new CancelacionMonto;
        $cancelacion_monto->subproyecto_id = $subproyecto->id;
        $cancelacion_monto->monto_cancelado = $request->monto_cancelado;
        $cancelacion_monto->motivo = $request->motivo;
        $cancelacion_monto->save();

        // cancelamos el monto del subproyecto
        $subproyecto->costo = $subproyecto->costo - $cancelacion_monto->monto_cancelado;
        $subproyecto->save();

        // retornamos respuesta
        return redirect()->route('subproyectos.cancelaciones.index', $subproyecto->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subproyecto $subproyecto, $id)
    {
        // chequeamos que exista el registro de cancelacion
        $cancelacion = CancelacionMonto::findOrFail($id);
        
        // retornamos respuesta
        return response()->json(['subproyecto' => $subproyecto, 'cancelacion' => $cancelacion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Subproyecto $subproyecto, $id)
    {
        // chequeamos que exista el registro de cancelacion
        $cancelacion = CancelacionMonto::findOrFail($id);
                
        return view('subproyectos.cancelaciones.edit', compact('subproyecto', 'cancelacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subproyecto $subproyecto, $id)
    {
        // Verificamos que exista el registro de cancelacion
        $cancelacion_monto = CancelacionMonto::findOrFail($id);
        $monto_disponible = $subproyecto->costo + $cancelacion_monto->monto_cancelado;

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

        // anulamos el monto cancelado del subproyecto
        $subproyecto->costo = $subproyecto->costo + $cancelacion_monto->monto_cancelado;
        $subproyecto->save();

        // modificamos el registro de cancelacion
        $cancelacion_monto->monto_cancelado = $request->monto_cancelado;
        $cancelacion_monto->motivo = $request->motivo;
        $cancelacion_monto->save();

        // cancelamos el monto del subproyecto
        $subproyecto->costo = $subproyecto->costo - $cancelacion_monto->monto_cancelado;
        $subproyecto->save();

        // retornamos respuesta
        return redirect()->route('subproyectos.cancelaciones.index', $subproyecto->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subproyecto $subproyecto, $id)
    {
        // Verificamos que exista el registro de cancelacion
        $cancelacion_monto = CancelacionMonto::findOrFail($id);
        // anulamos el monto cancelado del subproyecto
        $subproyecto->costo = $subproyecto->costo + $cancelacion_monto->monto_cancelado;
        $subproyecto->save();

        // eliminamos el registro de cancelacion
        $cancelacion_monto->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Registro de cancelación eliminado correctamente']);
    }

}