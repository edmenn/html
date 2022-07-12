<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display login page.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        if(!is_null($request->user())){
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function checkLogin(Request $request){
        // validamos los campos del formulario
        $rules = array(
            'email' => 'email|required|max:75',
            'password' => 'string|required',
        );
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $check = Auth::attempt($request->only('email', 'password'));
        if ($check) {
            // Authentication passed...
            return redirect()->route('dashboard');
        }else{
            // Authentication not passed...
            $validator->errors()->add('error', 'Credenciales no válidas.'); // Agregamos el error
            return back()->withErrors($validator)->withInput();
        }   
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request){
        if(!is_null($request->user())){
            Auth::logout();
        }
        return redirect()->route('login');
    }

}
