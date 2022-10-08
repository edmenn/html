<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Puerto;
use App\Models\User;
use App\Models\Estado;

class PresupuestosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verificarRol:administracion,jefe_departamental');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // obtenemos todos los presupuestos
        $presupuestos = Presupuesto::all();

        // retornamos respuesta
        return view('presupuestos.index', compact('presupuestos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $puertos = Puerto::all();
        $usuarios = User::whereIn('rol_id', [2,3])->get();

        return view('presupuestos.create', compact('puertos', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validamos los datos enviados
        $rules = array(
            'anho_fiscal' => 'required|string|max:4',
            'codigo' => 'required|string|max:12',
            'puerto_id' => 'required|integer|max:32767',
            'descripcion' => 'required|string|max:255',
            'costo' => 'required|integer|max:2147483647',
            'responsable_id' => 'required|integer',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // creamos un nuevo presupuesto
        $presupuesto = new Presupuesto;
        $presupuesto->anho_fiscal = $request->anho_fiscal;
        $presupuesto->codigo = $request->codigo;
        $presupuesto->puerto_id = $request->puerto_id;
        $presupuesto->descripcion = $request->descripcion;
        $presupuesto->costo = $request->costo;
        $presupuesto->responsable_id = $request->responsable_id;
        $presupuesto->estado_id = 1; // en proceso
        $presupuesto->save();

        // retornamos respuesta
        return redirect()->route('presupuestos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // chequeamos que exista el presupuesto
        $presupuesto = Presupuesto::findOrFail($id);

        // retornamos respuesta
        return response()->json(['presupuesto' => $presupuesto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $puertos = Puerto::all();
        $estados = Estado::all();
        $usuarios = User::whereIn('rol_id', [2,3])->get();

        return view('presupuestos.edit', compact('presupuesto', 'puertos', 'usuarios', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Verificamos que exista el presupuesto
        $presupuesto = Presupuesto::findOrFail($id);

        // validamos los datos enviados
        $rules = array(
            'anho_fiscal' => 'required|string|max:4',
            'codigo' => 'required|string|max:12',
            'puerto_id' => 'required|integer|max:32767',
            'descripcion' => 'required|string|max:255',
            'costo' => 'required|integer|max:2147483647',
            'responsable_id' => 'required|integer',
            'estado_id' => 'required|integer|max:32767',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el presupuesto
        $presupuesto->anho_fiscal = $request->anho_fiscal;
        $presupuesto->codigo = $request->codigo;
        $presupuesto->puerto_id = $request->puerto_id;
        $presupuesto->descripcion = $request->descripcion;
        $presupuesto->costo = $request->costo;
        $presupuesto->responsable_id = $request->responsable_id;
        $presupuesto->estado_id = $request->estado_id;
        $presupuesto->save();

        // retornamos respuesta
        return redirect()->route('presupuestos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verificamos que exista el presupuesto
        $presupuesto = Presupuesto::findOrFail($id);

        // eliminamos el presupuesto
        $presupuesto->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Presupuesto eliminado correctamente']);
    }

}