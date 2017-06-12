<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Alteracao;
use App\TipoAlteracao;
use App\AlteracaoInformacao;
use App\Pessoa;
use Illuminate\Http\Request;

class AlteracaoController extends Controller {

    public function index($id_empresa) {
        $alteracoes = Alteracao::where('id_pessoa', '=', $id_empresa)->orderBy('updated_at', 'desc')->get();
        $tipo_alteracoes = TipoAlteracao::orderBy('descricao', 'asc')->get();
        return view('empresa.alteracoes.index', ['alteracoes' => $alteracoes, 'id_empresa' => $id_empresa, 'tipo_alteracoes' => $tipo_alteracoes]);
    }
    public function indexAdmin() {
        $alteracoes = Alteracao::orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.alteracoes.index', ['alteracoes' => $alteracoes]);
    }

    public function create($id_empresa, $id_tipo) {
        $alteracao = \App\TipoAlteracao::find($id_tipo);
        $empresa = Pessoa::where('id', '=', $id_empresa)->where('id_usuario', '=', Auth::user()->id)->first();
        if ($empresa instanceof Pessoa) {
            return view('empresa.alteracoes.cadastrar', ['empresa' => $empresa, 'alteracao' => $alteracao]);
        }
        return redirect()->back();
    }

    public function store($id, $id_tipo, Request $request) {
        $erros = [];
        $empresa = Pessoa::where('id', '=', $id)->where('id_usuario', '=', Auth::user()->id)->first();
        if (!$empresa instanceof Pessoa) {
            return redirect()->back();
        }
        $alteracao = new Alteracao;
        $alteracao->id_tipo_alteracao = $id_tipo;
        $alteracao->id_pessoa = $id;
        $alteracao->save();
        if (count($request->all())) {
            foreach ($request->except('_token','anexo') as $k => $campo) {
                if (!$campo) {
                    $erros[] = 'É necessário preencher o campo ' . \App\AlteracaoCampo::where('id', '=', $k)->first()->nome;
                }
            }
        }
        if ($request->file('anexo')) {
            foreach ($request->file('anexo') as $k => $anexo) {
                if (!$anexo) {
                    $erros[] = 'É necessário preencher o campo ' . \App\AlteracaoCampo::where('id', '=', $k)->first()->nome;
                }
            }
        }
        if (count($erros)) {
            $alteracao->delete();
            return redirect(route('cadastrar-solicitacao-alteracao', [$id, $id_tipo]))->withErrors($erros)->withInput();
        }
        try {
            if (count($request->all())) {
                foreach ($request->except('_token','anexo') as $k => $campo) {
                    $informacao = new \App\AlteracaoInformacao;
                    $informacao->create(['id_alteracao_campo' => $k, 'id_alteracao' => $alteracao->id, 'valor' => $campo]);
                }
            }
            if ($request->file('anexo')) {
                foreach ($request->file('anexo') as $k => $anexo) {
                    $informacao = new \App\AlteracaoInformacao;
                    $anexo_nome = 'alteracao_anexo' . str_shuffle(date('dmyhis')) . '.' . $anexo->guessClientExtension();
                    
                    $anexo->move(getcwd() . '/uploads/alteracao/', $anexo_nome);
                    $informacao->create(['id_alteracao_campo' => $k, 'id_alteracao' => $alteracao->id, 'valor' => $anexo_nome]);
                }
            }
            $alteracao->abrir_ordem_pagamento();
            return redirect(route('listar-alteracoes', [$id]));
        } catch (Exception $ex) {
            $alteracao->delete();
            return redirect(route('cadastrar-solicitacao-alteracao', [$id, $id_tipo]))->withErrors($erros)->withInput();
        }
    }


    public function edit($id_empresa, $id_alteracao) {
        $alteracao = Alteracao::join('pessoa', 'pessoa.id', '=', 'alteracao.id_pessoa')->where('pessoa.id_usuario', '=', Auth::user()->id)->where('alteracao.id', '=', $id_alteracao)->where('pessoa.id', '=', $id_empresa)->select('alteracao.*')->first();
        if ($alteracao instanceof Alteracao) {
            return view('empresa.alteracoes.visualizar', ['alteracao' => $alteracao]);
        }
        return redirect()->back();
    }
    
    public function editAdmin($id_alteracao) {
        $alteracao = Alteracao::where('id', '=', $id_alteracao)->first();
        if ($alteracao instanceof Alteracao) {
            return view('admin.alteracoes.visualizar', ['alteracao' => $alteracao]);
        }
        return redirect()->back();
    }

    public function update($id_empresa, $id_alteracao, Request $request) {
        $mensagem = new \App\AlteracaoMensagem;
        $alteracao = Alteracao::join('pessoa', 'pessoa.id', '=', 'alteracao.id_pessoa')->where('pessoa.id_usuario', '=', Auth::user()->id)->where('alteracao.id', '=', $id_alteracao)->where('pessoa.id', '=', $id_empresa)->select('alteracao.*')->first();
        if (!$alteracao instanceof Alteracao) {
            return redirect()->back();
        }
        if ($mensagem->validate($request->all())) {
            if ($request->file('anexo')) {
                $anexo = date('dmyhis') . '.' . $request->file('anexo')->getClientOriginalExtension();
                $request->file('anexo')->move(getcwd() . '/uploads/alteracao/', $anexo);
                $request->merge(['anexo' => $anexo]);
                $mensagem->anexo = $anexo;
            }

            $mensagem->mensagem = $request->get('mensagem');
            $mensagem->id_alteracao = $id_alteracao;
            $mensagem->id_usuario = Auth::user()->id;
            $mensagem->save();
            $mensagem->enviar_notificacao_nova_mensagem_alteracao();
            $alteracao->touch();
            return redirect(route('visualizar-solicitacao-alteracao', [$id_empresa, $id_alteracao]));
        }
        return redirect(route('visualizar-solicitacao-alteracao', [$id_empresa, $id_alteracao]))->withInput()->with(['alteracao' => $alteracao])->withErrors($mensagem->errors());
    }
    
    public function updateAdmin($id_alteracao, Request $request) {
        $mensagem = new \App\AlteracaoMensagem;
        $alteracao = Alteracao::where('id', '=', $id_alteracao)->first();
        if (!$alteracao instanceof Alteracao) {
            return redirect()->back();
        }
        if ($mensagem->validate($request->all())) {
            if ($request->file('anexo')) {
                $anexo = date('dmyhis') . '.' . $request->file('anexo')->guessClientExtension();
                $request->file('anexo')->move(getcwd() . '/uploads/alteracao/', $anexo);
                $request->merge(['anexo' => $anexo]);
                $mensagem->anexo = $anexo;
            }

            $mensagem->mensagem = $request->get('mensagem');
            $mensagem->id_alteracao = $id_alteracao;
            $mensagem->id_usuario = Auth::user()->id;
            $mensagem->save();
            $alteracao->status = $request->get('status');
            $alteracao->save();
            $mensagem->enviar_notificacao_nova_mensagem_alteracao();
            
            return redirect(route('visualizar-solicitacao-alteracao-admin', [$id_alteracao]));
        }
        return redirect(route('visualizar-solicitacao-alteracao-admin', [$id_alteracao]))->withInput()->with(['alteracao' => $alteracao])->withErrors($mensagem->errors());
    }

}
