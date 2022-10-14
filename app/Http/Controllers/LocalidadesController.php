<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Localidad;

class LocalidadesController extends Controller
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
        // obtenemos todos los localidades
        $localidades = Localidad::all();

        // retornamos respuesta
        return view('localidades.index', compact('localidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('localidades.create');
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

        // creamos un nuevo localidad
        $localidad = new localidad;
        $localidad->nombre = $request->nombre;
        $localidad->direccion = $request->direccion;
        $localidad->save();

        // retornamos respuesta
        return redirect()->route('localidades.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // chequeamos que exista el localidad
        $localidad = Localidad::findOrFail($id);

        // retornamos respuesta
        return response()->json(['localidad' => $localidad]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $localidad = Localidad::findOrFail($id);

        return view('localidades.edit', compact('localidad'));
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
        // Verificamos que exista el localidad
        $localidad = Localidad::findOrFail($id);

        // validamos los datos enviados
        $rules = array(
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el localidad
        $localidad->nombre = $request->nombre;
        $localidad->direccion = $request->direccion;
        $localidad->save();

        // retornamos respuesta
        return redirect()->route('localidades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verificamos que exista el localidad
        $localidad = Localidad::findOrFail($id);

        // eliminamos el localidad
        $localidad->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'localidad eliminado correctamente']);
    }

}