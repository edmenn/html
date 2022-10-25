<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\OrdenCompra;

class OrdenesCompraController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // PERMISOS PARA ROLES DE ADMINISTRADOR Y JEFE DEPARTAMENTAL
        $this->middleware('verificarRol:administracion,jefe_departamental');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // obtenemos todas las ordenes de compra
        $ordenes_compra = OrdenCompra::all();

        // retornamos respuesta
        return view('ordenes_compra.index', compact('ordenes_compra'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        
        return view('ordenes_compra.create', compact('proveedores'));
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
            'concepto' => 'required|string|max:50',
            'proveedor_id' => 'required|integer|max:32767',
            'fecha_factura' => 'required|date_format:d/m/Y',
            'numero_factura' => 'required|string|max:15',
            'monto' => 'required|integer|max:2147483647',
            'iva' => 'required|integer|max:32767',
            'monto_iva' => 'required|integer|max:2147483647',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $fecha_factura_array = explode("/", $request->fecha_factura);
        $fecha_factura = $fecha_factura_array[2].'-'.$fecha_factura_array[1].'-'.$fecha_factura_array[0];

        // creamos una nueva orden de compra
        $orden_compra = new OrdenCompra;
        $orden_compra->concepto = $request->concepto;
        $orden_compra->proveedor_id = $request->proveedor_id;
        $orden_compra->fecha_factura = $fecha_factura;
        $orden_compra->numero_factura = $request->numero_factura;
        $orden_compra->monto = $request->monto;
        $orden_compra->iva = $request->iva;
        $orden_compra->monto_iva = $request->monto_iva;
        $orden_compra->save();

        // retornamos respuesta
        return redirect()->route('ordenes_compra.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // chequeamos que exista la orden de compra
        $orden_compra = OrdenCompra::findOrFail($id);

        // retornamos respuesta
        return response()->json(['orden_compra' => $orden_compra]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orden_compra = OrdenCompra::findOrFail($id);
        $proveedores = Proveedor::all();

        return view('ordenes_compra.edit', compact('orden_compra', 'proveedores'));
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
        // Verificamos que exista la orden de compra
        $orden_compra = OrdenCompra::findOrFail($id);

        // validamos los datos enviados
        $rules = array(
            'concepto' => 'required|string|max:50',
            'proveedor_id' => 'required|integer|max:32767',
            'fecha_factura' => 'required|date_format:d/m/Y',
            'numero_factura' => 'required|string|max:15',
            'monto' => 'required|integer|max:2147483647',
            'iva' => 'required|integer|max:32767',
            'monto_iva' => 'required|integer|max:2147483647',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $fecha_factura_array = explode("/", $request->fecha_factura);
        $fecha_factura = $fecha_factura_array[2].'-'.$fecha_factura_array[1].'-'.$fecha_factura_array[0];

        // modificamos la orden de compra
        $orden_compra->concepto = $request->concepto;
        $orden_compra->proveedor_id = $request->proveedor_id;
        $orden_compra->fecha_factura = $fecha_factura;
        $orden_compra->numero_factura = $request->numero_factura;
        $orden_compra->monto = $request->monto;
        $orden_compra->iva = $request->iva;
        $orden_compra->monto_iva = $request->monto_iva;
        $orden_compra->save();

        // retornamos respuesta
        return redirect()->route('ordenes_compra.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verificamos que exista la orden de compra
        $orden_compra = OrdenCompra::findOrFail($id);

        // eliminamos la orden de compra
        $orden_compra->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Orden de compra eliminada correctamente']);
    }

}