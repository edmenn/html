<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\Departamento;

class UsersController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // obtenemos todos los usuarios
        $users = User::all();

        // retornamos respuesta
        return view('usuarios.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Rol::all();
        $departamentos = Departamento::all();

        return view('usuarios.create', compact('roles', 'departamentos'));
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
            'rol_id' => 'required|integer|max:32767',
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'cedula' => 'required|string|max:15',
            'email' => 'required|email|max:75',
            'password' => 'required|string|max:255',
            'departamento_id' => 'required|integer|max:32767',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $check_email = User::where('email', $request->email)->count();
        if($check_email > 0){
            $validator->errors()->add('email', 'El email ingresado ya se encuentra vinculado a un usuario.');
            return back()->withErrors($validator)->withInput();   
        }

        // creamos un nuevo user
        $user = new user;
        $user->rol_id = $request->rol_id;
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->cedula = $request->cedula;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->departamento_id = $request->departamento_id;
        $user->save();

        // retornamos respuesta
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // chequeamos que exista el user
        $user = User::findOrFail($id);

        // retornamos respuesta
        return response()->json(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Rol::all();
        $departamentos = Departamento::all();

        return view('usuarios.edit', compact('user', 'roles', 'departamentos'));
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
        // Verificamos que exista el user
        $user = User::findOrFail($id);

        // validamos los datos enviados
        $rules = array(
            'rol_id' => 'required|integer|max:32767',
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'cedula' => 'required|string|max:15',
            'email' => 'required|email|max:75',
            'departamento_id' => 'required|integer|max:32767',
        );

        $validator =  Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if($request->email != $user->email){
            $check_email = User::where('email', $request->email)->where('id', '!=', $id)->count();
            if($check_email > 0){
                $validator->errors()->add('email', 'El email ingresado ya se encuentra vinculado a un usuario.');
                return back()->withErrors($validator)->withInput();   
            }
        }

        // modificamos el usuario
        $user->rol_id = $request->rol_id;
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->cedula = $request->cedula;
        $user->email = $request->email;
        $user->departamento_id = $request->departamento_id;
        $user->save();

        // retornamos respuesta
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verificamos que exista el usuario
        $user = User::findOrFail($id);

        // eliminamos el usuario (en caso de ser administrador rechazamos la eliminacion)
        if($user->rol_id == 1){
            return response()->json(['status' => 'error', 'message' => 'El Usuario que intenta eliminar es el usuario administrador del sistema.']);
        }

        $user->delete();
        
        // retornamos respuesta
        return response()->json(['status' => 'success', 'message' => 'Usuario eliminado correctamente']);
    }

}