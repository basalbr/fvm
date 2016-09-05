<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
class HomeController extends Controller {

    public function index() {
        $id = session('user')->id;
        $has_pessoa = session('user')->pessoa ? true : false;
        if (session('user')->pessoa) {
            $nome = session('user')->pessoa['nome'];
            $apelido = session('user')->pessoa['apelido'];
            $cpf = session('user')->pessoa['cpf_cnpj'];
            $tipo = session('user')->pessoa['tipo'];
            $data_nascimento = session('user')->pessoa['data_nascimento'];
        } else {
            $nome = Input::old('nome');
            $apelido = Input::old('apelido');
            $cpf = Input::old('cpf_cnpj');
            $tipo = Input::old('tipo');
            $data_nascimento = Input::old('data_nascimento');
        }
        $data_nascimento = date('d-m-Y', strtotime($data_nascimento));
        return view('dados-pessoais.index', ['id' => $id, 'nome' => $nome, 'apelido' => $apelido, 'cpf' => $cpf, 'tipo' => $tipo, 'data_nascimento' => $data_nascimento, 'has_pessoa' => $has_pessoa]);
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
            return redirect(route('login'))->withInput(['email' => $request->input('email'), 'nome'=>$usuario->nome]);
        }else{
            return redirect(route('registrar'))->with('email', $request->input('email'));
        }
    }
   
    public function curl(){
        return 'IT WORKZ';
    }

}
