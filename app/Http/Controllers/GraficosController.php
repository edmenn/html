<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Presupuesto;
use App\Models\Proyecto;
use App\Models\Subproyecto;
use App\Models\Adjudicacion;
use App\Models\Proveedor;

class GraficosController extends Controller
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
     * Get barraPresupuestoVsGasto data.
     *
     * @return \Illuminate\Http\Response
     */
    public function barraPresupuestoVsGastoData(Request $request){
        $anho_fiscal = $request->input('anho_fiscal');
        $data = Presupuesto::selectRaw('presupuestos.id, presupuestos.nombre, presupuestos.anho_fiscal, presupuestos.codigo, 
                            presupuestos.costo, presupuestos.tipo, COALESCE(SUM(proyectos.contratado), 0) as gasto_real')
                ->leftJoin('proyectos', 'presupuestos.id', '=', 'proyectos.presupuesto_id')
                ->anhoFiscalWhere($anho_fiscal)
                ->groupByRaw('presupuestos.id, presupuestos.nombre, presupuestos.anho_fiscal, presupuestos.codigo, presupuestos.costo, presupuestos.tipo')
                ->get();

        // retornamos respuesta
        return response()->json(['data' => $data]);
    }

    /**
     * Get barraLicitacionesProveedor data.
     *
     * @return \Illuminate\Http\Response
     */
    public function barraLicitacionesProveedorData(Request $request){
        $proveedor = $request->input('proveedor');
        $data = Adjudicacion::selectRaw("SUM(licitaciones.monto) as monto_adjudicado, proveedores.nombre_fantasia")
                ->leftJoin('licitaciones', 'licitaciones.id', '=', 'adjudicaciones.licitacion_id')
                ->leftJoin('proveedores', 'proveedores.id', '=', 'licitaciones.proveedor_id')
                ->when($proveedor, function ($query, $proveedor) {
                    return $query->where('licitaciones.proveedor_id', $proveedor);
                })
                ->groupByRaw("proveedores.nombre_fantasia")
                ->get();

        // retornamos respuesta
        return response()->json(['data' => $data]);
    }

    /**
     * Get pastelgastosProyecto data.
     *
     * @return \Illuminate\Http\Response
     */
    public function pastelGastosProyectoData(Request $request){
        $presupuesto = $request->input('presupuesto');
        $data = Proyecto::selectRaw("nombre, costo")
                ->when($presupuesto, function ($query, $presupuesto) {
                    return $query->where('presupuesto_id', $presupuesto);
                })
                ->get();

        // retornamos respuesta
        return response()->json(['data' => $data]);
    }
}
