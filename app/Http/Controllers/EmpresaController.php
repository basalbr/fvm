<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller {

    public function index() {
        $empresas = \App\Pessoa::where('id_usuario', '=', Auth::user()->id)->orderBy('nome_fantasia')->get();
        return view('empresa.index', ['empresas' => $empresas]);
    }

    public function create() {
        $tipoTributacoes = \App\TipoTributacao::orderBy('descricao', 'asc')->get();
        $naturezasJuridicas = \App\NaturezaJuridica::orderBy('descricao', 'asc')->get();
        return view('empresa.cadastrar', [ 'tipoTributacoes' => $tipoTributacoes, 'naturezasJuridicas' => $naturezasJuridicas]);
    }

    public function store(Request $request) {
        $empresa = new \App\Pessoa;
        $request->merge(['id_usuario' => Auth::user()->id]);

        if ($empresa->validate($request->except('_token'))) {

            $request->merge([
                'cpf_cnpj' => intval(preg_replace('/[^0-9]+/', '', $request->get('cpf_cnpj')), 10),
                'cep' => intval(preg_replace('/[^0-9]+/', '', $request->get('cep')), 10),
                'telefone' => intval(preg_replace('/[^0-9]+/', '', $request->get('telefone')), 10),
            ]);
            $empresa = $empresa->create($request->except('_token', 'cnaes'));
            if (count($request->get('cnaes'))) {
                foreach ($request->get('cnaes') as $cnae) {
                    if (\App\Cnae::where('id', '=', $cnae)->first()->id_tabela_simples_nacional == null) {
                        $empresa->delete();
                        return redirect(route('cadastrar-empresa'))->withInput()->withErrors(['Não foi possível cadastrar sua empresa pois um de seus CNAEs não está apto para o Simples Nacional.\nNesse momento só trabalhamos com Simples Nacional.']);
                    } else {
                        $pessoaCnae = new \App\PessoaCnae;
                        $pessoaCnae->id_pessoa = $empresa->id;
                        $pessoaCnae->id_cnae = $cnae;
                        $pessoaCnae->save();
                    }
                }
            }
            return redirect(route('empresas'));
        } else {
            return redirect(route('cadastrar-empresa'))->withInput()->withErrors($empresa->errors());
        }
    }

    public function register() {
        return view('register.index');
    }

    public function checkEmail(Request $request) {
        $usuario = \App\Usuario::where('email', '=', $request->input('email'))->first();
        if ($usuario instanceof \App\Usuario) {
            return redirect(route('login'))->with('email', $request->input('email'));
        } else {
            return redirect(route('registrar'));
        }
    }

    public function registerForm() {
        
    }

}
