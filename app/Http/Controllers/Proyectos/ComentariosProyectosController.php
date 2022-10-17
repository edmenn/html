<?php

namespace App\Http\Controllers\Proyectos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Proyecto;

class ComentariosProyectosController extends Controller
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
        // obtenemos todas las comentarios del proyecto
        $comentarios = Comentario::where('proyecto_id', $proyecto->id)->get();

        // retornamos respuesta
        return view('comentariosproyectos.index', compact('proyecto', 'comentarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Proyecto $proyecto)
    {
        return view('comentariosproyectos.create', compact('proyecto'));
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
        $rules = array('comentario' => 'required|string');

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // creamos una nueva comentario de monto
        $comentario = new Comentario;
        $comentario->proyecto_id = $proyecto->id;
        $comentario->comentario = $request->comentario;
        $comentario->save();

        // retornamos respuesta
        return redirect()->route('comentariosproyectos.index', $proyecto->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto, $id)
    {
        // chequeamos que exista el registro de comentario
        $comentario = Comentario::findOrFail($id);
        
        // retornamos respuesta
        return response()->json(['proyecto' => $proyecto, 'comentario' => $comentario]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto, $id)
    {
        // chequeamos que exista el registro de comentario
        $comentario = Comentario::findOrFail($id);
                
        return view('comentariosproyectos.edit', compact('proyecto', 'comentario'));
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
        // Verificamos que exista el registro de comentario
        $comentario = Comentario::findOrFail($id);

        // validamos los datos enviados
        $rules = array('comentario' => 'required|string');

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el registro de comentario
        $comentario->comentario = $request->comentario;
        $comentario->save();

        // retornamos respuesta
        return redirect()->route('comentariosproyectos.index', $proyecto->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto, $id)
    {
        // Verificamos que exista el registro de comentario
        $comentario = Comentario::findOrFail($id);

        // eliminamos el registro de comentario
        $comentario->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Registro de cancelación eliminado correctamente']);
    }

}