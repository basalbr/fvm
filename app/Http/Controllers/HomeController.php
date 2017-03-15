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

    public function site() {
        $atendimento = false;
        $horario1 = \DateTime::createFromFormat('H:i a', '8:00 am');
        $horario2 = \DateTime::createFromFormat('H:i a', '12:00 pm');
        $horario3 = \DateTime::createFromFormat('H:i a', '1:30 pm');
        $horario4 = \DateTime::createFromFormat('H:i a', '6:00 pm');
        
        $horario_atual = \DateTime::createFromFormat('H:i a', date('h:i A'));
        if (date('w') <= 5 && date('w') >= 1 && (($horario1 <= $horario_atual && $horario2 >= $horario_atual) || ($horario3 <= $horario_atual && $horario4 >= $horario_atual))) {
            $atendimento = true;
        }
        $atendimento = false;

        return view('index', ['atendimento'=>$atendimento]);
    }

    public function acessar() {
        return view('acessar.index');
    }

    public function register() {
        return view('register.index');
    }

    public function checkEmail(Request $request) {
        $usuario = \App\Usuario::where('email', '=', $request->input('email'))->first();
        if ($usuario instanceof \App\Usuario) {
            return redirect(route('login'))->withInput(['email' => $request->input('email'), 'nome' => $usuario->nome]);
        } else {
            return redirect(route('registrar'))->withInput(['email' => $request->input('email')]);
        }
    }

    public function ajaxContato(Request $request) {
        $nome = $request->get('nome');
        $assunto = $request->get('assunto');
        $email = $request->get('email');
        $mensagem = $request->get('mensagem');
        \Illuminate\Support\Facades\Mail::send('emails.novo-contato-site', ['nome' => $nome, 'assunto' => $assunto, 'email' => $email, 'mensagem' => $mensagem], function ($m) use ($assunto, $email,$nome) {
            $m->from($email, $nome);
            $m->to(['admin@webcontabilidade.com', 'silmara@i9ge.com.br', 'sil0511@gmail.com'])->subject($assunto);
        });
    }

    public function curl() {
        return 'IT WORKZ';
    }

}
