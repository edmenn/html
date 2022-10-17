<?php

namespace App\Http\Controllers\Subproyectos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\TipoDocumento;
use App\Models\Subproyecto;

class DocumentosSubproyectosController extends Controller
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
    public function index(Subproyecto $subproyecto)
    {
        // obtenemos todas las documentos del subproyecto
        $documentos = Documento::where('subproyecto_id', $subproyecto->id)->get();

        // retornamos respuesta
        return view('documentossubproyectos.index', compact('subproyecto', 'documentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Subproyecto $subproyecto)
    {
        $tipos_documento = TipoDocumento::all();
        return view('documentossubproyectos.create', compact('subproyecto', 'tipos_documento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Subproyecto $subproyecto)
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
        // Cargamos el archivo (ruta storage/app/public/subproyectos/{subproyecto_id}/ is un enlace simbolico desde public/subproyectos/{subproyecto_id}/)
        $path = $archivo->storeAs('public/subproyectos/'.$subproyecto->id, $nombre_archivo);

        // creamos una nuevo documento
        $documento = new documento;
        $documento->subproyecto_id = $subproyecto->id;
        $documento->tipo_documento_id = $request->tipo_documento_id;
        $documento->nombre = $request->nombre;
        $documento->archivo = $nombre_archivo;
        $documento->save();

        // retornamos respuesta
        return redirect()->route('documentossubproyectos.index', $subproyecto->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subproyecto $subproyecto, $id)
    {
        // Verificamos que exista el registro de documento
        $documento = Documento::findOrFail($id);
        $x = 'puto';

        // eliminamos el archivo guardado
        if (Storage::exists('public/subproyectos/'.$subproyecto->id.'/'.$documento->archivo)){
            Storage::delete('public/subproyectos/'.$subproyecto->id.'/'.$documento->archivo);
        }

        // eliminamos el registro de documento
        $documento->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Documento eliminado correctamente']);
    }

}