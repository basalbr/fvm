<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Processo;

class AberturaEmpresaController extends Controller {

    public function index() {
        $empresas = \App\AberturaEmpresa::where('id_usuario', '=', Auth::user()->id)->orderBy('nome_empresarial1')->get();
        return view('abertura_empresa.index', ['empresas' => $empresas]);
    }

    public function create() {
        $tipoTributacoes = \App\TipoTributacao::orderBy('descricao', 'asc')->get();
        $naturezasJuridicas = \App\NaturezaJuridica::orderBy('descricao', 'asc')->get();
        return view('abertura_empresa.cadastrar', [ 'tipoTributacoes' => $tipoTributacoes, 'naturezasJuridicas' => $naturezasJuridicas]);
    }

    public function store(Request $request) {
//        dd($request->all());
        $empresa = new \App\AberturaEmpresa;
        $request->merge(['id_usuario' => Auth::user()->id]);
        if (count($request->get('cnaes'))) {
            foreach ($request->get('cnaes') as $cnae) {
                if (\App\Cnae::where('id', '=', $cnae)->first()->id_tabela_simples_nacional == null) {
                    return redirect(route('cadastrar-abertura-empresa'))->withInput()->withErrors(['Não foi possível cadastrar sua empresa pois um de seus CNAEs não está apto para o Simples Nacional.\nNesse momento só trabalhamos com Simples Nacional.']);
                }
            }
        }
        if (!count($request->get('socio'))) {
            return redirect(route('cadastrar-abertura-empresa'))->withInput()->withErrors(['É necessário cadastrar pelo menos um sócio']);
        }
        //atencao, arrumar telefone!!!!!!!!!!!!!!!!!!!!
        $request->merge([
            'id_tipo_tributacao' => 1,
            'status_pagamento'=>'Aguardando pagamento',
            'status'=>'Novo'
        ]);
        if ($empresa->validate($request->all())) {
            $empresa = $empresa->create($request->all());
            if (count($request->get('socio'))) {
                foreach ($request->get('socio') as $obj) {
                    $socio = new \App\AberturaEmpresaSocio;
                    $obj['id_abertura_empresa'] = $empresa->id;
                     $old_date = explode('/', $obj['data_nascimento']);
            $new_date = $old_date[2] . '-' . $old_date[1] . '-' . $old_date[0];
                    $obj['data_nascimento'] = $new_date;
                    if($socio->validate($obj)){
                        $socio = $socio->create($obj);
                    }else{
                        \App\AberturaEmpresa::find($empresa->id)->delete();
                        return redirect(route('cadastrar-abertura-empresa'))->withInput()->withErrors($socio->errors());
                    }
                    
                }
            }
            if (count($request->get('cnaes'))) {
                foreach ($request->get('cnaes') as $cnae) {
                    $pessoaCnae = new \App\AberturaEmpresaCnae;
                    $pessoaCnae->id_abertura_empresa = $empresa->id;
                    $pessoaCnae->id_cnae = $cnae;
                    $pessoaCnae->save();
                }
            }
           
            return redirect(route('abertura-empresa'));
        } else {
            return redirect(route('cadastrar-empresa'))->withInput()->withErrors($empresa->errors());
        }
    }

    public function edit($id) {
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->where('id_usuario', '=', Auth::user()->id)->first();
        return view('abertura_empresa.editar', ['empresa' => $empresa]);
    }

    public function update($id, Request $request) {

        $empresa = \App\Pessoa::where('id', '=', $id)->where('id_usuario', '=', Auth::user()->id)->first();
        $request->merge(['id' => $empresa->id]);
        if (count($request->get('cnaes'))) {
            foreach ($request->get('cnaes') as $cnae) {
                if (\App\Cnae::where('id', '=', $cnae)->first()->id_tabela_simples_nacional == null) {
                    return redirect(route('editar-empresa', $id))->withInput()->withErrors(['Não foi possível cadastrar sua empresa pois um de seus CNAEs não está apto para o Simples Nacional.\nNesse momento só trabalhamos com Simples Nacional.']);
                }
            }
        }

        if ($empresa->validate($request->except('_token'), true)) {

            $empresa->update($request->except('_token', 'cnaes', 'socio'));
            if (count($request->get('cnaes'))) {
                foreach ($empresa->cnaes()->get() as $cnae) {
                    $cnae->delete();
                }
                foreach ($request->get('cnaes') as $cnae) {
                    $pessoaCnae = new \App\PessoaCnae;
                    $pessoaCnae->id_pessoa = $id;
                    $pessoaCnae->id_cnae = $cnae;
                    $pessoaCnae->save();
                }
            }
            $usuario = Auth::user();
            \Illuminate\Support\Facades\Mail::send('emails.editar-empresa', ['nome' => $usuario->nome, 'empresa' => $empresa], function ($m) use ($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Nova empresa cadastrada');
            });
            return redirect(route('empresas'));
        } else {
            return redirect(route('editar-empresa', [$id]))->withInput()->withErrors($empresa->errors());
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

    public function validateSocio(Request $request) {
        $socio = new \App\AberturaEmpresaSocio;
        if ($request->get('data_nascimento')) {
            $old_date = explode('/', $request->get('data_nascimento'));
            $new_date = $old_date[2] . '-' . $old_date[1] . '-' . $old_date[0];
            $request->merge(['data_nascimento' => $new_date]);
        }
        if (!$socio->validate($request->all())) {
            return $socio->errors();
        }
    }

    public function validateAberturaEmpresa(Request $request) {
        $empresa = new \App\AberturaEmpresa;
        if (!$empresa->validate($request->all())) {
            if (!$request->get('socio')) {
                return array_merge($empresa->errors(), ['É necessário incluir ao menos um sócio']);
            }
            return $empresa->errors();
        }
    }

}
