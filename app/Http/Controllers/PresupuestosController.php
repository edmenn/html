<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Localidad;
use App\Models\User;
use App\Models\Estado;
use App\Models\Departamento;

class PresupuestosController extends Controller
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
             ->only(['create', 'store', 'edit', 'update', 'destroy', 'ultimoCodigo', 'editEstado', 'updateEstado']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // obtenemos los parametros
        $mostrar = $request->input('mostrar');
        $mostrar = is_null($mostrar) ? 10 : $mostrar;
        $localidad = $request->input('localidad');
        $departamento = $request->input('departamento');
        $anho_fiscal = $request->input('anho_fiscal');
        $estado = $request->input('estado');

        // definimos los filtros
        $localidades = Localidad::all();
        $departamentos = Departamento::all();
        $estados = Estado::all();
        $anho_fiscales = Presupuesto::selectRaw('distinct(anho_fiscal)')->pluck('anho_fiscal');

        // obtenemos los presupuestos
        $presupuestos = Presupuesto::with(['localidad:id,nombre', 'departamento:id,nombre', 
                            'responsable:id,nombre,apellido', 'estado:id,nombre'])
                        ->localidadWhere($localidad)
                        ->departamentoWhere($departamento)
                        ->anhoFiscalWhere($anho_fiscal)
                        ->estadoWhere($estado)
                        ->paginate($mostrar)
                        ->appends('mostrar', $mostrar)
                        ->appends('localidad', $localidad)
                        ->appends('departamento', $departamento)
                        ->appends('anho_fiscal', $anho_fiscal)
                        ->appends('estado', $estado);

        // retornamos respuesta
        return view('presupuestos.index', compact('presupuestos', 'localidades', 'departamentos', 'estados', 
                    'anho_fiscales', 'mostrar', 'localidad', 'departamento', 'anho_fiscal', 'estado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $localidades = Localidad::all();
        $departamentos = Departamento::all();
        $usuarios = User::whereIn('rol_id', [2,3])->get();

        return view('presupuestos.create', compact('localidades', 'departamentos', 'usuarios'));
    }

    /**
     * Get lasta code from budget.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ultimoCodigo(Request $request){
        // PARAMETERS
        $anho_fiscal = $request->input('anho_fiscal');
        $anho_fiscal = !is_numeric($anho_fiscal) ? NULL : $anho_fiscal;
        if(is_null($anho_fiscal)){
            return response()->json(['status' => 'error', 'message' => 'Respuesta no encontrada!', 'code' => 200], 200);
        }else{
            // RELATED DATA
            $presupuesto = Presupuesto::where('anho_fiscal', $anho_fiscal)->orderBy('codigo', 'desc')->take(1)->get();
            $codigo = is_null($presupuesto->first()) ? 1 : intval($presupuesto->first()->codigo)+1;
            return response()->json(['status' => 'success', 'codigo' => $codigo], 200);
        }
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
            'anho_fiscal' => 'required|integer|max:9999',
            'codigo' => 'required|integer|max:999',
            'localidad_id' => 'required|integer|max:32767',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|in:CAPEX,OPEX',
            'costo' => 'required|integer|max:2147483647',
            'departamento_id' => 'required|integer|max:32767',
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
        $presupuesto->localidad_id = $request->localidad_id;
        $presupuesto->nombre = $request->nombre;
        $presupuesto->descripcion = $request->descripcion;
        $presupuesto->tipo = $request->tipo;
        $presupuesto->costo = $request->costo;
        $presupuesto->departamento_id = $request->departamento_id;
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
        $localidades = Localidad::all();
        $departamentos = Departamento::all();
        $usuarios = User::whereIn('rol_id', [2,3])->get();

        return view('presupuestos.edit', compact('presupuesto', 'localidades', 'departamentos', 
                                                'usuarios'));
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
            'anho_fiscal' => 'required|integer|max:9999',
            'codigo' => 'required|integer|max:999',
            'localidad_id' => 'required|integer|max:32767',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|in:CAPEX,OPEX',
            'costo' => 'required|integer|max:2147483647',
            'departamento_id' => 'required|integer|max:32767',
            'responsable_id' => 'required|integer',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el presupuesto
        $presupuesto->anho_fiscal = $request->anho_fiscal;
        $presupuesto->codigo = $request->codigo;
        $presupuesto->localidad_id = $request->localidad_id;
        $presupuesto->nombre = $request->nombre;
        $presupuesto->descripcion = $request->descripcion;
        $presupuesto->tipo = $request->tipo;
        $presupuesto->costo = $request->costo;
        $presupuesto->departamento_id = $request->departamento_id;
        $presupuesto->responsable_id = $request->responsable_id;
        $presupuesto->save();

        // retornamos respuesta
        return redirect()->route('presupuestos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editEstado($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $estados = Estado::all();

        return view('presupuestos.edit-estado', compact('presupuesto', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEstado(Request $request, $id)
    {
        // Verificamos que exista el presupuesto
        $presupuesto = Presupuesto::findOrFail($id);

        // validamos los datos enviados
        $rules = array('estado_id' => 'required|integer|max:32767');

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // modificamos el estado del presupuesto
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