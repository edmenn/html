<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Licitacion;
use App\Models\Adjudicacion;

class AdjudicacionesController extends Controller
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
        $this->middleware('verificarRol:administracion,jefe_departamental');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Licitacion $licitacion)
    {
        // Verificamos que el proyecto o subproyecto relacionado no tenga ninguna adjudicacion
        if(!is_null($licitacion->proyecto_id)){
            $adjudicacion = Adjudicacion::where('licitaciones.proyecto_id', $licitacion->proyecto_id)
                            ->join('licitaciones', 'licitaciones.id', '=', 'adjudicaciones.licitacion_id')
                            ->get();
        }else{
            $adjudicacion = Adjudicacion::where('licitaciones.subproyecto_id', $licitacion->subproyecto_id)
                            ->join('licitaciones', 'licitaciones.id', '=', 'adjudicaciones.licitacion_id')
                            ->get();
        }

        // en caso de haber una adjudicación existente retornamos
        if($adjudicacion->count() > 0){
            return response()->json(['status' => 'warning', 'message' => "El proyecto/subproyecto que está 
            relacionado con la licitación ya tiene una adjudicación relacionada, elimine primeramente dicha 
            adjudicación y luego puede efectuar esta operación nuevamente."], 200);
        }

        // no hay ninguna adjudicación existente entonces creamos una
        $adjudicacion = new Adjudicacion;
        $adjudicacion->licitacion_id = $licitacion->id;
        $adjudicacion->fecha_adjudicacion = date('Y-m-d');
        $adjudicacion->save();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Registro de adjudicación creado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Licitacion $licitacion, $id)
    {
        // Verificamos que exista la adjudicacion
        $adjudicacion = Adjudicacion::findOrFail($id);

        // eliminamos el registro de adjudicacion
        $adjudicacion->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Registro de adjudicación eliminado correctamente']);
    }

}