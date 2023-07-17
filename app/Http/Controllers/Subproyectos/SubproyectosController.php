<?php

namespace App\Http\Controllers\Subproyectos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Subproyecto;
use App\Models\Departamento;
use App\Models\User;
use App\Models\Estado;

class SubproyectosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // PERMISOS PARA ROLES DE ADMINISTRADOR Y JEFE DEPARTAMENTAL
        $this->middleware('verificarRol:administracion,jefe_departamental')
             ->only(['create', 'store', 'destroy', 'editEstado', 'updateEstado']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Proyecto $proyecto)
    {
        // obtenemos todos los subproyectos
        $subproyectos = Subproyecto::where('proyecto_id', $proyecto->id)->get();

        // retornamos respuesta
        return view('subproyectos.index', compact('proyecto', 'subproyectos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Proyecto $proyecto)
    {
        return view('subproyectos.create', compact('proyecto'));
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
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'codigo' => 'required|string|max:12',
            'costo' => 'required|integer|max:2147483647',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // creamos un nuevo subproyecto
        $subproyecto = new Subproyecto;
        $subproyecto->proyecto_id = $proyecto->id;
        $subproyecto->nombre = $request->nombre;
        $subproyecto->descripcion = $request->descripcion;
        $subproyecto->codigo = $request->codigo;
        $subproyecto->costo = $request->costo;
        $subproyecto->contratado = 0;
        $subproyecto->estado_id = 1; // en proceso
        $subproyecto->save();

        // retornamos respuesta
        return redirect()->route('proyectos.subproyectos.index', $proyecto->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto, $id)
    {
        // chequeamos que exista el subproyecto
        $subproyecto = Subproyecto::findOrFail($id);

        // retornamos respuesta
        return response()->json(['subproyecto' => $subproyecto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto, $id)
    {
        $subproyecto = Subproyecto::findOrFail($id);

        return view('subproyectos.edit', compact('proyecto', 'subproyecto'));
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
        // Verificamos que exista el subproyecto
        $subproyecto = Subproyecto::findOrFail($id);

        // validamos los datos enviados
        $rules = array(
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'codigo' => 'required|string|max:12',
            'contratado' => 'required|integer|max:2147483647',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el subproyecto
        $subproyecto->nombre = $request->nombre;
        $subproyecto->descripcion = $request->descripcion;
        $subproyecto->codigo = $request->codigo;
        $subproyecto->contratado = $request->contratado;
        $subproyecto->save();

        // retornamos respuesta
        return redirect()->route('proyectos.subproyectos.index', $proyecto->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editEstado(Proyecto $proyecto, $id)
    {
        $subproyecto = Subproyecto::findOrFail($id);
        $estados = Estado::all();

        return view('subproyectos.edit-estado', compact('proyecto', 'subproyecto', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEstado(Request $request, Proyecto $proyecto, $id)
    {
        // Verificamos que exista el subproyecto
        $subproyecto = Subproyecto::findOrFail($id);

        // validamos los datos enviados
        $rules = array('estado_id' => 'required|integer|max:32767');

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el estado del subproyecto
        $subproyecto->estado_id = $request->estado_id;
        $subproyecto->save();

        // retornamos respuesta
        return redirect()->route('proyectos.subproyectos.index', $proyecto->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto, $id)
    {
        // Verificamos que exista el subproyecto
        $subproyecto = Subproyecto::findOrFail($id);

        // eliminamos el subproyecto
        $subproyecto->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'subproyecto eliminado correctamente']);
    }

}