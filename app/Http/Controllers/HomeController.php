<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Localidad;
use App\Models\User;
use App\Models\Presupuesto;
use App\Models\Proveedor;

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

        $localidades = Localidad::all()->count();
        $users = User::all()->count();
        $presupuestos = Presupuesto::all()->count();
        $proveedores = Proveedor::all()->count();

        return view('dashboard', compact('localidades', 'users', 'presupuestos', 'proveedores'));
    }

}
