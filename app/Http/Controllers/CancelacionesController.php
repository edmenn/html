<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\CancelacionMonto;
use App\Models\Presupuesto;
use App\Models\Proyecto;
use App\Models\Subproyecto;
use App\Models\Departamento;
use App\Models\User;
use App\Models\Estado;

class CancelacionesController extends Controller
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
    public function index($tipo, $id)
    {
        $proyecto = NULL;
        $subproyecto = NULL;
        switch ($tipo) {
            case 'proyecto':
                $proyecto = Proyecto::findOrFail($id);
                // obtenemos todas las cancelaciones del proyecto
                $cancelaciones = CancelacionMonto::where('proyecto_id', $id)->get();
                break;
            case 'subproyecto':
                $subproyecto = Subproyecto::findOrFail($id);
                // obtenemos todas las cancelaciones del subproyecto
                $cancelaciones = CancelacionMonto::where('subproyecto_id', $id)->get();
                break;
            default:
                abort(404);
                break;
        }

        // retornamos respuesta
        return view('cancelaciones.index', compact('tipo', 'id', 'proyecto', 'subproyecto', 'cancelaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tipo, $id)
    {
        $proyecto = NULL;
        $subproyecto = NULL;
        switch ($tipo) {
            case 'proyecto':
                $proyecto = Proyecto::findOrFail($id);
                break;
            case 'subproyecto':
                $subproyecto = Subproyecto::findOrFail($id);
                break;
            default:
                abort(404);
                break;
        }

        return view('cancelaciones.create', compact('tipo', 'id', 'proyecto', 'subproyecto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $tipo, $id)
    {
        // obtenemos el proyecto o subproyecto
        $proyecto = NULL;
        $subproyecto = NULL;
        switch ($tipo) {
            case 'proyecto':
                $proyecto = Proyecto::findOrFail($id);
                $item_id = $proyecto->id;
                $monto_disponible = $proyecto->costo;
                break;
            case 'subproyecto':
                $subproyecto = Subproyecto::findOrFail($id);
                $item_id = $subproyecto->id;
                $monto_disponible = $subproyecto->costo;
                break;
            default:
                abort(404);
                break;
        }

        // validamos los datos enviados
        switch ($tipo) {
            case 'proyecto':
                $rules = array(
                    'proyecto_id' => 'required|integer|max:2147483647',
                    'monto_cancelado' => 'required|integer|max:2147483647',
                    'motivo' => 'required|string',
                );
                break;
            case 'subproyecto':
                $rules = array(
                    'subproyecto_id' => 'required|integer|max:2147483647',
                    'monto_cancelado' => 'required|integer|max:2147483647',
                    'motivo' => 'required|string',
                );
                break;
            default:
                abort(404);
                break;
        }

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // verificamos que el monto cancelado no sea mayor al monto disponible
        if($monto_disponible < $request->monto_cancelado){
            $validator->errors()->add('monto_cancelado', 'Monto a cancelar es mayor al monto disponible.'); // Agregamos el error
            return back()->withErrors($validator)->withInput();
        }

        // creamos una nueva cancelacion de monto
        $cancelacion_monto = new CancelacionMonto;
        $cancelacion_monto->proyecto_id = $request->proyecto_id;
        $cancelacion_monto->subproyecto_id = $request->subproyecto_id;
        $cancelacion_monto->monto_cancelado = $request->monto_cancelado;
        $cancelacion_monto->motivo = $request->motivo;
        $cancelacion_monto->save();

        if($tipo == 'proyecto'){
            // cancelamos el monto del proyecto
            $proyecto->costo = $proyecto->costo - $cancelacion_monto->monto_cancelado;
            $proyecto->save();
        }else{
            // cancelamos el monto del subproyecto
            $subproyecto->costo = $subproyecto->costo - $cancelacion_monto->monto_cancelado;
            $subproyecto->save();
        }

        // retornamos respuesta
        return redirect()->route('cancelaciones.index', ['tipo' => $tipo, 'id' => $item_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tipo, $id)
    {
        // obtenemos el proyecto o subproyecto
        $proyecto = NULL;
        $subproyecto = NULL;
        switch ($tipo) {
            case 'proyecto':
                // chequeamos que exista el registro de cancelacion
                $cancelacion = CancelacionMonto::findOrFail($id);
                $proyecto = Proyecto::findOrFail($cancelacion->proyecto_id);
                break;
            case 'subproyecto':
                // chequeamos que exista el registro de cancelacion
                $cancelacion = CancelacionMonto::findOrFail($id);
                $subproyecto = Subproyecto::findOrFail($cancelacion->subproyecto_id);
                break;
            default:
                abort(404);
                break;
        }
        
        // retornamos respuesta
        return response()->json(['tipo' => $tipo, 'proyecto' => $proyecto, 'subproyecto' => $subproyecto, 
                                'cancelacion' => $cancelacion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tipo, $id)
    {
        $proyecto = NULL;
        $subproyecto = NULL;
        switch ($tipo) {
            case 'proyecto':
                // chequeamos que exista el registro de cancelacion
                $cancelacion = CancelacionMonto::findOrFail($id);
                $proyecto = Proyecto::findOrFail($cancelacion->proyecto_id);
                break;
            case 'subproyecto':
                // chequeamos que exista el registro de cancelacion
                $cancelacion = CancelacionMonto::findOrFail($id);
                $subproyecto = Subproyecto::findOrFail($cancelacion->subproyecto_id);
                break;
            default:
                abort(404);
                break;
        }

        return view('cancelaciones.edit', compact('tipo', 'id', 'proyecto', 'subproyecto', 'cancelacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tipo, $id)
    {
        // Verificamos que exista el registro de cancelacion
        $cancelacion_monto = CancelacionMonto::findOrFail($id);

        // obtenemos el proyecto o subproyecto
        $proyecto = NULL;
        $subproyecto = NULL;
        switch ($tipo) {
            case 'proyecto':
                $proyecto = Proyecto::findOrFail($cancelacion_monto->proyecto_id);
                $item_id = $proyecto->id;
                $monto_disponible = $proyecto->costo + $cancelacion_monto->monto_cancelado;
                break;
            case 'subproyecto':
                $subproyecto = Subproyecto::findOrFail($cancelacion_monto->subproyecto_id);
                $item_id = $subproyecto->id;
                $monto_disponible = $subproyecto->costo + $cancelacion_monto->monto_cancelado;
                break;
            default:
                abort(404);
                break;
        }

        // validamos los datos enviados
        switch ($tipo) {
            case 'proyecto':
                $rules = array(
                    'monto_cancelado' => 'required|integer|max:2147483647',
                    'motivo' => 'required|string',
                );
                break;
            case 'subproyecto':
                $rules = array(
                    'monto_cancelado' => 'required|integer|max:2147483647',
                    'motivo' => 'required|string',
                );
                break;
            default:
                abort(404);
                break;
        }

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // verificamos que el monto cancelado no sea mayor al monto disponible
        if($monto_disponible < $request->monto_cancelado){
            $validator->errors()->add('monto_cancelado', 'Monto a cancelar es mayor al monto disponible.'); // Agregamos el error
            return back()->withErrors($validator)->withInput();
        }

        // Anulamos el monto cancelado anteriormente
        if($tipo == 'proyecto'){
            // anulamos el monto cancelado del proyecto
            $proyecto->costo = $proyecto->costo + $cancelacion_monto->monto_cancelado;
            $proyecto->save();
        }else{
            // anulamos el monto cancelado del subproyecto
            $subproyecto->costo = $subproyecto->costo + $cancelacion_monto->monto_cancelado;
            $subproyecto->save();
        }

        // modificamos el registro de cancelacion
        $cancelacion_monto->monto_cancelado = $request->monto_cancelado;
        $cancelacion_monto->motivo = $request->motivo;
        $cancelacion_monto->save();

        if($tipo == 'proyecto'){
            // cancelamos el monto del proyecto
            $proyecto->costo = $proyecto->costo - $cancelacion_monto->monto_cancelado;
            $proyecto->save();
        }else{
            // cancelamos el monto del subproyecto
            $subproyecto->costo = $subproyecto->costo - $cancelacion_monto->monto_cancelado;
            $subproyecto->save();
        }

        // retornamos respuesta
        return redirect()->route('cancelaciones.index', ['tipo' => $tipo, 'id' => $item_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tipo, $id)
    {
        $proyecto = NULL;
        $subproyecto = NULL;
        switch ($tipo) {
            case 'proyecto':
                // Verificamos que exista el registro de cancelacion
                $cancelacion_monto = CancelacionMonto::findOrFail($id);
                $proyecto = Proyecto::findOrFail($cancelacion_monto->proyecto_id);
                // anulamos el monto cancelado del proyecto
                $proyecto->costo = $proyecto->costo + $cancelacion_monto->monto_cancelado;
                $proyecto->save();
                break;
            case 'subproyecto':
                // Verificamos que exista el registro de cancelacion
                $cancelacion_monto = CancelacionMonto::findOrFail($id);
                $subproyecto = Subproyecto::findOrFail($cancelacion_monto->subproyecto_id);
                // anulamos el monto cancelado del subproyecto
                $subproyecto->costo = $subproyecto->costo + $cancelacion_monto->monto_cancelado;
                $subproyecto->save();
                break;
            default:
                abort(404);
                break;
        }

        // eliminamos el registro de cancelacion
        $cancelacion_monto->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Registro de cancelacion eliminado correctamente']);
    }

}