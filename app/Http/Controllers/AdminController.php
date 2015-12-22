<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
class DashboardController extends Controller {

    public function index() {
      return view('dashboard.index');
    }

    public function acessar() {
        return view('acessar.index');
    }
    
    public function register() {
        return view('register.index');
    }
    
    public function checkEmail(Request $request) {
        $usuario = \App\Usuario::where('email','=',$request->input('email'))->first();
        if($usuario instanceof \App\Usuario){
            return redirect(route('login'))->with('email', $request->input('email'));
        }else{
            return redirect(route('registrar'));
        }
    }
    
    public function registerForm(){
        
    }

}
