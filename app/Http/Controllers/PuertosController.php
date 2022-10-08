<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Puerto;

class PuertosController extends Controller
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
        // obtenemos todos los puertos
        $puertos = Puerto::all();

        // retornamos respuesta
        return view('puertos.index', compact('puertos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('puertos.create');
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
            'direccion' => 'required|string|max:255',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // creamos un nuevo puerto
        $puerto = new puerto;
        $puerto->nombre = $request->nombre;
        $puerto->direccion = $request->direccion;
        $puerto->save();

        // retornamos respuesta
        return redirect()->route('puertos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // chequeamos que exista el puerto
        $puerto = Puerto::findOrFail($id);

        // retornamos respuesta
        return response()->json(['puerto' => $puerto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $puerto = Puerto::findOrFail($id);

        return view('puertos.edit', compact('puerto'));
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
        // Verificamos que exista el puerto
        $puerto = Puerto::findOrFail($id);

        // validamos los datos enviados
        $rules = array(
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el puerto
        $puerto->nombre = $request->nombre;
        $puerto->direccion = $request->direccion;
        $puerto->save();

        // retornamos respuesta
        return redirect()->route('puertos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verificamos que exista el puerto
        $puerto = Puerto::findOrFail($id);

        // eliminamos el puerto
        $puerto->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Puerto eliminado correctamente']);
    }

}