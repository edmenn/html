<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        return view('dashboard');
    }

}
