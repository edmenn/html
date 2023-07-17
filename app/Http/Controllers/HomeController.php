<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Localidad;
use App\Models\User;
use App\Models\Presupuesto;
use App\Models\Proveedor;
use App\Models\Proyecto;
use App\Models\Subproyecto;
use App\Models\Adjudicacion;

class HomeController extends Controller
{
    /**
     * Display dashboard page.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request){
        if(is_null($request->user())){
            return redirect()->route('login');
        }

        $anho_fiscal = Presupuesto::select('anho_fiscal')
                ->groupBy('anho_fiscal')
                ->get();
        $proveedores = Proveedor::all();
        $presupuestos = Presupuesto::all();
        $presupuesto = $presupuestos->first()->id;

        return view('dashboard', compact('anho_fiscal', 'proveedores', 'presupuestos', 'presupuesto'));
    }

}
