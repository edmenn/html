<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\TipoDocumento;
use App\Models\OrdenCompra;

class DocumentosOrdenesCompraController extends Controller
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
    public function index(OrdenCompra $orden_compra)
    {
        // obtenemos todos las documentos del ordencompra
        $documentos = Documento::where('orden_compra_id', $orden_compra->id)->get();

        // retornamos respuesta
        return view('ordenes_compra.documentos.index', compact('orden_compra', 'documentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(OrdenCompra $orden_compra)
    {
        $tipos_documento = TipoDocumento::all();
        return view('ordenes_compra.documentos.create', compact('orden_compra', 'tipos_documento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, OrdenCompra $orden_compra)
    {
        $archivo = $request->file('archivo');

        // validamos los datos enviados
        $rules = array(
            'tipo_documento_id' => 'required|integer|max:32767',
            'nombre' => 'required|string|max:50',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // verificamos que se haya cargado un archivo
        if(!$request->hasFile('archivo')){
            $validator->errors()->add('archivo', 'ERROR. DEBE CARGAR UNA IMAGEN.');
            return back()->withErrors($validator)->withInput();
        }

        // verificamos que el archivo no pese más que cierto tamaño (1 MB)
        $size = ($archivo->getSize() / 1024 / 1024);
        if ($size > 1) {
            $validator->errors()->add('archivo', 'ERROR DE CARGA. ARCHIVO MUY PESADO (Supera 1MB).');
            return back()->withErrors($validator)->withInput();
        }

        // cargamos el archivo
        $extension = $archivo->extension();
        $nombre_archivo = time().'-documento'.'.'.$extension;
        // Cargamos el archivo (ruta storage/app/public/ordenes_compra/{orden_compra_id}/ is un enlace simbolico desde public/ordenes_compra/{orden_compra_id}/)
        $path = $archivo->storeAs('public/ordenes_compra/'.$orden_compra->id, $nombre_archivo);

        // creamos un nuevo documento
        $documento = new Documento;
        $documento->orden_compra_id = $orden_compra->id;
        $documento->tipo_documento_id = $request->tipo_documento_id;
        $documento->nombre = $request->nombre;
        $documento->archivo = $nombre_archivo;
        $documento->save();

        // retornamos respuesta
        return redirect()->route('documentos.ordenes_compra.index', $orden_compra->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdenCompra $orden_compra, $id)
    {
        // Verificamos que exista el registro de documento
        $documento = Documento::findOrFail($id);

        // eliminamos el archivo guardado
        if (Storage::exists('public/ordenes_compra/'.$orden_compra->id.'/'.$documento->archivo)){
            Storage::delete('public/ordenes_compra/'.$orden_compra->id.'/'.$documento->archivo);
        }

        // eliminamos el registro de documento
        $documento->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Documento eliminado correctamente']);
    }

}