<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Proyecto;
use App\Models\Departamento;
use App\Models\User;
use App\Models\Estado;

class ProyectosController extends Controller
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
    public function index(Presupuesto $presupuesto)
    {
        // obtenemos todos los proyectos
        $proyectos = Proyecto::where('presupuesto_id', $presupuesto->id)->get();

        // retornamos respuesta
        return view('proyectos.index', compact('presupuesto', 'proyectos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Presupuesto $presupuesto)
    {
        $usuarios = User::whereIn('rol_id', [2,3])->get();

        return view('proyectos.create', compact('presupuesto', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Presupuesto $presupuesto)
    {
        // validamos los datos enviados
        $rules = array(
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'anho_fiscal' => 'required|string|max:4',
            'codigo' => 'required|string|max:12',
            'user_id' => 'required|integer|max:2147483647',
            'costo' => 'required|integer|max:2147483647',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // creamos un nuevo proyecto
        $proyecto = new Proyecto;
        $proyecto->presupuesto_id = $presupuesto->id;
        $proyecto->nombre = $request->nombre;
        $proyecto->descripcion = $request->descripcion;
        $proyecto->anho_fiscal = $request->anho_fiscal;
        $proyecto->codigo = $request->codigo;
        $proyecto->user_id = $request->user_id;
        $proyecto->costo = $request->costo;
        $proyecto->contratado = 0;
        $proyecto->estado_id = 1; // en proceso
        $proyecto->save();

        // retornamos respuesta
        return redirect()->route('presupuestos.proyectos.index', $presupuesto->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Presupuesto $presupuesto, $id)
    {
        // chequeamos que exista el proyecto
        $proyecto = Proyecto::findOrFail($id);

        // retornamos respuesta
        return response()->json(['proyecto' => $proyecto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Presupuesto $presupuesto, $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $usuarios = User::whereIn('rol_id', [2,3])->get();

        return view('proyectos.edit', compact('presupuesto', 'proyecto', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presupuesto $presupuesto, $id)
    {
        // Verificamos que exista el proyecto
        $proyecto = Proyecto::findOrFail($id);

        // validamos los datos enviados
        $rules = array(
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'anho_fiscal' => 'required|string|max:4',
            'codigo' => 'required|string|max:12',
            'user_id' => 'required|integer|max:2147483647',
            'contratado' => 'required|integer|max:2147483647',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el proyecto
        $proyecto->nombre = $request->nombre;
        $proyecto->descripcion = $request->descripcion;
        $proyecto->anho_fiscal = $request->anho_fiscal;
        $proyecto->codigo = $request->codigo;
        $proyecto->user_id = $request->user_id;
        $proyecto->contratado = $request->contratado;
        $proyecto->save();

        // retornamos respuesta
        return redirect()->route('presupuestos.proyectos.index', $presupuesto->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editEstado(Presupuesto $presupuesto, $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $estados = Estado::all();

        return view('proyectos.edit-estado', compact('presupuesto', 'proyecto', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEstado(Request $request, Presupuesto $presupuesto, $id)
    {
        // Verificamos que exista el proyecto
        $proyecto = Proyecto::findOrFail($id);

        // validamos los datos enviados
        $rules = array('estado_id' => 'required|integer|max:32767');

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el estado del proyecto
        $proyecto->estado_id = $request->estado_id;
        $proyecto->save();

        // retornamos respuesta
        return redirect()->route('presupuestos.proyectos.index', $presupuesto->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presupuesto $presupuesto, $id)
    {
        // Verificamos que exista el proyecto
        $proyecto = Proyecto::findOrFail($id);

        // eliminamos el proyecto
        $proyecto->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Proyecto eliminado correctamente']);
    }

}