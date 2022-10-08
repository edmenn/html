<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedoresController extends Controller
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
        // obtenemos todos los proveedores
        $proveedores = Proveedor::all();

        // retornamos respuesta
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proveedores.create');
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
            'nombre_fantasia' => 'required|string|max:150',
            'razon_social' => 'required|string|max:150',
            'ruc' => 'required|string|max:15',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:150',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // creamos un nuevo proveedor
        $proveedor = new Proveedor;
        $proveedor->nombre_fantasia = $request->nombre_fantasia;
        $proveedor->razon_social = $request->razon_social;
        $proveedor->ruc = $request->ruc;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->save();

        // retornamos respuesta
        return redirect()->route('proveedores.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // chequeamos que exista el proveedor
        $proveedor = Proveedor::findOrFail($id);

        // retornamos respuesta
        return response()->json(['proveedor' => $proveedor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        return view('proveedores.edit', compact('proveedor'));
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
        // Verificamos que exista el proveedor
        $proveedor = Proveedor::findOrFail($id);

        // validamos los datos enviados
        $rules = array(
            'nombre_fantasia' => 'required|string|max:150',
            'razon_social' => 'required|string|max:150',
            'ruc' => 'required|string|max:15',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:150',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el proveedor
        $proveedor->nombre_fantasia = $request->nombre_fantasia;
        $proveedor->razon_social = $request->razon_social;
        $proveedor->ruc = $request->ruc;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->save();

        // retornamos respuesta
        return redirect()->route('proveedores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verificamos que exista el proveedor
        $proveedor = Proveedor::findOrFail($id);

        // eliminamos el proveedor
        $proveedor->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'proveedor eliminado correctamente']);
    }

}