<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Proyecto;
use App\Models\Subproyecto;
use App\Models\Adjudicacion;
use App\Models\OrdenCompra;

class ReportesController extends Controller
{
    /**
     * Display presupuesto reportes page.
     *
     * @return \Illuminate\Http\Response
     */
    public function presupuesto(Request $request){
        $presupuesto = $request->input('presupuesto');
        $presupuestos = !is_null($presupuesto) ? Presupuesto::where('id', $presupuesto)->get() : Presupuesto::all();
        $presupuestos_list = Presupuesto::all();

        return view('reportes.presupuesto', compact('presupuestos', 'presupuestos_list', 'presupuesto'));
    }

    /**
     * Display gasto reportes page.
     *
     * @return \Illuminate\Http\Response
     */
    public function gasto(Request $request){
        $presupuesto_id = $request->input('presupuesto');
        $presupuesto = null;
        if(is_null($presupuesto_id)){
            $gastos_totales = Presupuesto::selectRaw('sum(costo) as gasto_total')->get()->first()->gasto_total;
            $gastos_proyectos = Proyecto::selectRaw('sum(costo) as gasto_total')->get()->first()->gasto_total;
            $gastos_subproyectos = Subproyecto::selectRaw('sum(costo) as gasto_total')->get()->first()->gasto_total;
            $gastos_proveedor1 = Adjudicacion::selectRaw('sum(licitaciones.monto) as gasto_total')
                                ->leftJoin('licitaciones', 'licitaciones.id', '=', 'adjudicaciones.licitacion_id')
                                ->get()->first()->gasto_total;
            $gastos_proveedor2 = OrdenCompra::selectRaw('sum(monto) as gasto_total')->get()->first()->gasto_total;
            $gastos_proveedor = intval($gastos_proveedor1) + intval($gastos_proveedor2);
        }else{
            $presupuesto = Presupuesto::find($presupuesto_id);
            $gastos_totales = Presupuesto::selectRaw('sum(costo) as gasto_total')
                                ->where('id', $presupuesto_id)
                                ->get()->first()->gasto_total;
            $gastos_proyectos = Proyecto::selectRaw('sum(costo) as gasto_total')
                                ->where('presupuesto_id', $presupuesto_id)
                                ->get()->first()->gasto_total;
            $gastos_subproyectos = Subproyecto::selectRaw('sum(subproyectos.costo) as gasto_total')
                                ->leftJoin('proyectos', 'proyectos.id', '=', 'subproyectos.proyecto_id')
                                ->where('proyectos.presupuesto_id', $presupuesto_id)
                                ->get()->first()->gasto_total;
            $gastos_proveedor1 = Adjudicacion::selectRaw('sum(licitaciones.monto) as gasto_total')
                                ->leftJoin('licitaciones', 'licitaciones.id', '=', 'adjudicaciones.licitacion_id')
                                ->leftJoin('proyectos', 'proyectos.id', '=', 'licitaciones.proyecto_id')
                                ->where('proyectos.presupuesto_id', $presupuesto_id)
                                ->get()->first()->gasto_total;
            $gastos_proveedor2 = Adjudicacion::selectRaw('sum(licitaciones.monto) as gasto_total')
                                ->leftJoin('licitaciones', 'licitaciones.id', '=', 'adjudicaciones.licitacion_id')
                                ->leftJoin('subproyectos', 'subproyectos.id', '=', 'licitaciones.subproyecto_id')
                                ->leftJoin('proyectos', 'proyectos.id', '=', 'subproyectos.proyecto_id')
                                ->where('proyectos.presupuesto_id', $presupuesto_id)
                                ->get()->first()->gasto_total;
            $gastos_proveedor = intval($gastos_proveedor1) + intval($gastos_proveedor2);
        }
        $presupuestos = Presupuesto::all();

        return view('reportes.gasto', compact('presupuestos', 'presupuesto', 'presupuesto_id', 'gastos_totales', 'gastos_proyectos', 
                                            'gastos_subproyectos', 'gastos_proveedor'));
    }

    /**
     * Display presupuesto restante reportes page.
     *
     * @return \Illuminate\Http\Response
     */
    public function presupuestoRestante(Request $request){
        $presupuesto = $request->input('presupuesto');
        $presupuestos = !is_null($presupuesto) ? Presupuesto::where('id', $presupuesto)->get() : Presupuesto::all();
        $presupuestos_list = Presupuesto::all();

        return view('reportes.presupuestoRestante', compact('presupuestos', 'presupuestos_list', 'presupuesto'));
    }
}
