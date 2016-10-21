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

    public function indexAdmin() {
        $empresas = \App\AberturaEmpresa::orderBy('nome_empresarial1')->get();
        return view('admin.abertura_empresa.index', ['empresas' => $empresas]);
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
            'status_pagamento' => 'Aguardando pagamento',
            'status' => 'Novo'
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
                    if ($socio->validate($obj)) {
                        $socio = $socio->create($obj);
                    } else {
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
            $pagamento = new \App\Pagamento;
            $pagamento->tipo = 'abertura_empresa';
            $pagamento->id_abertura_empresa = $empresa->id;
            $pagamento->valor = 49.99;
            $pagamento->status = 'Pendente';
            $pagamento->vencimento = date('Y-m-d H:i:s', strtotime("+7 day"));
            $pagamento->save();
            return redirect(route('abertura-empresa'));
        } else {
            return redirect(route('cadastrar-abertura-empresa'))->withInput()->withErrors($empresa->errors());
        }
    }

    public function edit($id) {
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->where('id_usuario', '=', Auth::user()->id)->first();
        return view('abertura_empresa.editar', ['empresa' => $empresa]);
    }
    
    public function editAdmin($id) {
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->first();
        return view('admin.abertura_empresa.editar', ['empresa' => $empresa]);
    }

    public function update($id, Request $request) {
        $mensagem = new \App\AberturaEmpresaComentario;
        if ($mensagem->validate($request->all())) {
            if ($request->file('anexo')) {
                $anexo = date('dmyhis') . '.' . $request->file('anexo')->guessClientExtension();
                $request->file('anexo')->move(getcwd() . '/uploads/abertura_empresa/', $anexo);
                $request->merge(['anexo' => $anexo]);
                $mensagem->anexo = $anexo;
            }
            $mensagem->mensagem = $request->get('mensagem');
            $mensagem->id_abertura_empresa = $id;
            $mensagem->id_usuario = Auth::user()->id;
            $mensagem->save();
            return redirect(route('editar-abertura-empresa', [$id]));
        }
        return redirect(route('cadastrar-abertura-empresa'))->withInput()->withErrors($mensagem->errors());
    }
    
    public function updateAdmin($id, Request $request) {
        $mensagem = new \App\AberturaEmpresaComentario;
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->first();
        if ($mensagem->validate($request->all())) {
            if ($request->file('anexo')) {
                $anexo = date('dmyhis') . '.' . $request->file('anexo')->guessClientExtension();
                $request->file('anexo')->move(getcwd() . '/uploads/abertura_empresa/', $anexo);
                $request->merge(['anexo' => $anexo]);
                $mensagem->anexo = $anexo;
            }
            
            $empresa->status = $request->get('status');
            $empresa->save();
            $mensagem->mensagem = $request->get('mensagem');
            $mensagem->id_abertura_empresa = $id;
            $mensagem->id_usuario = Auth::user()->id;
            $mensagem->save();
            return redirect(route('editar-abertura-empresa-admin', [$id]));
        }
        return redirect(route('cadastrar-abertura-empresa-admin'))->withInput()->withErrors($mensagem->errors());
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
