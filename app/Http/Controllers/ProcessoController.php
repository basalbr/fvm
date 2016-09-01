<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Processo;
use App\ProcessoResposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProcessoController extends Controller {

    public function index() {
        $processos = Processo::orderBy('updated_at', 'desc')->get();
        return view('admin.processos.index', ['processos' => $processos]);
    }

    public function indexUsuario() {
        $processos = Processo::join('pessoa','pessoa.id','=','processo.id_pessoa')->where('pessoa.id_usuario', '=', Auth::user()->id)->orderBy('status', 'updated_at')->get();
        return view('processos.index', ['processos' => $processos]);
    }

    public function create($competencia, $id_imposto, $cnpj, $vencimento, Request $request) {
        $imposto = \App\Imposto::where('id', '=', $id_imposto)->first();
        $empresa = \App\Pessoa::where('cpf_cnpj', '=', $cnpj)->where('id_usuario', '=', Auth::user()->id)->first();
        return view('processos.cadastrar', ['competencia' => $competencia, 'empresa' => $empresa, 'vencimento' => $vencimento, 'imposto' => $imposto]);
    }

    public function store(Request $request) {
//        dd($request->all());
        $processo = new Processo;
        $pessoa = \App\Pessoa::where('id', '=', $request->get('id_pessoa'))->first();
//        $request->merge(['id_usuario' => Auth::user()->id]);
        if ($processo->validate($request->all())) {
            $vencimento = explode('-', $request->get('vencimento'));
            $competencia = explode('-', $request->get('competencia'));
            $request->merge(['vencimento' => $vencimento[0] . '-' . $vencimento[1] . '-' . $vencimento[2], 'competencia' => $competencia[0] . '-' . $competencia[1] . '-01','status'=>'pendente']);
            $processo = $processo->create($request->all());
            $erros = [];
            if ($request->get('informacao_adicional')) {
                foreach ($request->get('informacao_adicional') as $id => $informacao_adicional) {
                    if (!$informacao_adicional) {
                        $erros[] = 'É necessário preencher o campo ' . \App\InformacaoExtra::where('id', '=', $id)->first()->nome;
                    }
                }
            }
            if ($request->file('anexo')) {
                foreach ($request->file('anexo') as $id => $anexo) {
                    $informacao_extra = \App\InformacaoExtra::where('id', '=', $id)->first();
                    $nome_bonito = ['informacao' => $informacao_extra->nome];
                    $extensoes = '';
                    foreach ($informacao_extra->extensoes as $k => $extensao) {
                        if ($k > 0) {
                            $extensoes.=',';
                        }
                        $extensoes.=$extensao->extensao;
                    }
                    $rules = ['informacao' => 'required|max:' . $informacao_extra->tamanho_maximo . '|mimes:' . $extensoes];
                    // make a new validator object
                    $v = Validator::make(['informacao' => $anexo], $rules);
                    $v->setAttributeNames($nome_bonito);
                    if ($v->fails()) {
                        $erros = array_merge($erros, $v->errors()->all());
                    }
                }
            }
            if (count($erros)) {
                $processo->delete();
                return redirect(route('abrir-processo', ['competencia' => $request->get('competencia'), 'id_imposto' => $request->get('id_imposto'), 'cnpj' => $pessoa->cpf_cnpj, 'vencimento' => $request->get('vencimento')]))->withInput()->withErrors($erros);
            }
            foreach ($request->get('informacao_adicional') as $id => $informacao_adicional) {
                $informacao_extra = new \App\ProcessoInformacaoExtra;
                $informacao_extra->create(['informacao' => $informacao_adicional, 'id_processo' => $processo->id, 'id_informacao_extra' => $id]);
            }
            foreach ($request->file('anexo') as $id => $anexo) {
                $informacao_extra = new \App\ProcessoInformacaoExtra;
                $anexo_nome = 'processo_anexo' . str_shuffle(date('dmyhis')) . '.' . $anexo->guessClientExtension();
                $anexo->move(getcwd() . '/uploads/processos/', $anexo_nome);
                $informacao_extra->create(['informacao' => $anexo_nome, 'id_processo' => $processo->id, 'id_informacao_extra' => $id]);
            }
            return redirect(route('listar-processos'));
        } else {
            dd($processo->errors());
            return redirect(route('cadastrar-processo'))->withInput()->withErrors($processo->errors());
        }
        return redirect(route('listar-processos'));
    }

    public function edit($id) {
        $processo = Processo::where('id', '=', $id)->first();
        return view('processos.visualizar', ['processo' => $processo]);
    }

    public function update($id, Request $request) {
        $resposta = new ProcessoResposta;
        $request->merge(['id_usuario' => Auth::user()->id]);
        $request->merge(['id_processo' => $id]);
        if ($resposta->validate($request->only('mensagem'))) {
            $resposta->create($request->only('mensagem', 'id_usuario', 'id_processo'));
            if ($request->is('admin/*')) {
                return redirect(route('listar-processos'));
            }
            return redirect(route('listar-processos-usuario'));
        } else {
            if ($request->is('admin/*')) {
                return redirect(route('visualizar-processos', $id))->withInput()->withErrors($resposta->errors());
            }
            return redirect(route('responder-processo-usuario', $id))->withInput()->withErrors($resposta->errors());
        }
    }

    public function ajax(Request $request) {
        $lista = Processo::where('descricao', 'ilike', '%' . $request->get('search') . '%')->orWhere('codigo', 'ilike', '%' . $request->get('search') . '%')->orderBy('descricao')->take(5)->get(['descricao', 'codigo']);
        return response()->json($lista);
    }

}
