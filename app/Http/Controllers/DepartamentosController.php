<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Departamento;

class DepartamentosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verificarRol:administracion');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // obtenemos todas las departamentos
        $departamentos = Departamento::all();

        // retornamos respuesta
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departamentos.create');
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
            'nombre' => 'required|string|max:100',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // creamos una nueva departamento
        $departamento = new departamento;
        $departamento->nombre = $request->nombre;
        $departamento->save();

        // retornamos respuesta
        return redirect()->route('departamentos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // chequeamos que exista la departamento
        $departamento = Departamento::findOrFail($id);

        // retornamos respuesta
        return response()->json(['departamento' => $departamento]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);

        return view('departamentos.edit', compact('departamento'));
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
        // Verificamos que exista la departamento
        $departamento = Departamento::findOrFail($id);

        // validamos los datos enviados
        $rules = array(
            'nombre' => 'required|string|max:100',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos la departamento
        $departamento->nombre = $request->nombre;
        $departamento->save();

        // retornamos respuesta
        return redirect()->route('departamentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verificamos que exista la departamento
        $departamento = Departamento::findOrFail($id);

        // Si hay presupuestos relacionados al departamento no lo eliminamos
        if($departamento->presupuestos->count() > 0){
            return response()->json(['status' => 'error', 'message' => 'No se pudo eliminar el departamento, hay presupuestos relacionados a el, elimine previamente los presupuestos.']);
        }

        // eliminamos la departamento
        $departamento->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Departamento eliminado correctamente']);
    }

}