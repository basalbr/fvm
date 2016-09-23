<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Processo;
use App\ProcessoResposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ProcessoController extends Controller {

    public function abreProcessos() {
        $impostos_mes = \App\ImpostoMes::where('mes', '=', date('n'))->get();
        $competencia = date('Y-m-d', strtotime(date('Y-m') . " -1 month"));
        foreach ($impostos_mes as $imposto_mes) {
            $pessoas = \App\Pessoa::all();
            foreach ($pessoas as $pessoa) {
                $imposto = $imposto_mes->imposto;
                $processo = new Processo;
                $processo->create([
                    'id_pessoa' => $pessoa->id,
                    'competencia' => $competencia,
                    'id_imposto' => $imposto_mes->id_imposto,
                    'vencimento' => $imposto->corrigeData(date('Y') . '-' . date('m') . '-' . $imposto->vencimento, 'Y-m-d'),
                    'status' => 'novo'
                ]);
            }
        }
    }

    public function index() {
        $processos = Processo::orderBy('status', 'updated_at')->get();
        return view('admin.processos.index', ['processos' => $processos]);
    }

    public function indexUsuario() {

        $processos = Processo::query();

        $processos->join('pessoa', 'pessoa.id', '=', 'processo.id_pessoa')->where('pessoa.id_usuario', '=', Auth::user()->id)->where('processo.status', '<>', 'concluido');

        if (Input::get('competencia_de')) {
            $data = explode('/', Input::get('competencia_de'));
            $data = $data[2] . '-' . $data[1] . '-' . '01';
            $processos->where('processo.competencia', '>=', $data);
        }
        if (Input::get('competencia_ate')) {
            $data = explode('/', Input::get('competencia_ate'));
            $data = $data[2] . '-' . $data[1] . '-' . '01';
            $processos->where('processo.competencia', '<=', $data);
        }
        if (Input::get('vencimento_de')) {
            $data = explode('/', Input::get('vencimento_de'));
            $data = $data[2] . '-' . $data[1] . '-' . $data[0];
            $processos->where('processo.vencimento', '>=', $data);
        }
        if (Input::get('vencimento_ate')) {
            $data = explode('/', Input::get('vencimento_ate'));
            $data = $data[2] . '-' . $data[1] . '-' . $data[0];
            $processos->where('processo.vencimento', '<=', $data);
        }

        if (Input::get('empresa')) {
            $processos->where('processo.id_pessoa', '=', Input::get('empresa'));
        }
        if (Input::get('imposto')) {
            $processos->where('processo.id_imposto', '=', Input::get('imposto'));
        }
        if (Input::get('status')) {
            $processos->where('processo.status', '=', Input::get('status'));
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'vencimento_desc') {
                $processos->orderBy('processo.vencimento', 'desc');
            }
            if (Input::get('ordenar') == 'competencia_desc') {
                $processos->orderBy('processo.competencia', 'desc');
            }
        } else {
            $processos->orderBy('processo.competencia', 'desc');
        }

        $processos = $processos->select('processo.*')->paginate(10);

        return view('processos.index', ['processos' => $processos]);
    }

    public function create($competencia, $id_imposto, $cnpj, $vencimento, Request $request) {
        $imposto = \App\Imposto::where('id', '=', $id_imposto)->first();
        $empresa = \App\Pessoa::where('cpf_cnpj', '=', $cnpj)->where('id_usuario', '=', Auth::user()->id)->first();
        return view('processos.cadastrar', ['competencia' => $competencia, 'empresa' => $empresa, 'vencimento' => $vencimento, 'imposto' => $imposto]);
    }

    public function store($id, Request $request) {
        $processo = Processo::join('pessoa', 'processo.id_pessoa', '=', 'pessoa.id')->where('pessoa.id_usuario', '=', Auth::user()->id)->where('processo.id', '=', $id)->select('processo.*')->first();
        $erros = [];
        if ($request->get('informacao_adicional')) {
            foreach ($request->get('informacao_adicional') as $k => $informacao_adicional) {
                if (!$informacao_adicional) {
                    $erros[] = 'É necessário preencher o campo ' . \App\InformacaoExtra::where('id', '=', $k)->first()->nome;
                }
            }
        }
        if ($request->file('anexo')) {
            foreach ($request->file('anexo') as $k => $anexo) {
                $informacao_extra = \App\InformacaoExtra::where('id', '=', $k)->first();
                $nome_bonito = ['informacao' => $informacao_extra->nome];
                $extensoes = '';
                foreach ($informacao_extra->extensoes as $x => $extensao) {
                    if ($x > 0) {
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
            return redirect(route('responder-processo-usuario', [$id]))->withErrors($erros);
        }
        if ($request->get('informacao_adicional')) {
            foreach ($request->get('informacao_adicional') as $k => $informacao_adicional) {
                $informacao_extra = new \App\ProcessoInformacaoExtra;
                $informacao_extra->create(['informacao' => $informacao_adicional, 'id_processo' => $processo->id, 'id_informacao_extra' => $k]);
            }
        }
        if ($request->file('anexo')) {
            foreach ($request->file('anexo') as $k => $anexo) {
                $informacao_extra = new \App\ProcessoInformacaoExtra;
                $anexo_nome = 'processo_anexo' . str_shuffle(date('dmyhis')) . '.' . $anexo->guessClientExtension();
                $anexo->move(getcwd() . '/uploads/processos/', $anexo_nome);
                $informacao_extra->create(['informacao' => $anexo_nome, 'id_processo' => $processo->id, 'id_informacao_extra' => $k]);
            }
        }
        return redirect(route('responder-processo-usuario', [$id]));
    }

    public function edit($id) {
        $processo = Processo::join('pessoa', 'processo.id_pessoa', '=', 'pessoa.id')->where('pessoa.id_usuario', '=', Auth::user()->id)->where('processo.id', '=', $id)->select('processo.*')->with('pessoa')->first();
        return view('admin.processos.visualizar', ['processo' => $processo]);
    }

    public function editUsuario($id) {
        $processo = Processo::join('pessoa', 'processo.id_pessoa', '=', 'pessoa.id')->where('pessoa.id_usuario', '=', Auth::user()->id)->where('processo.id', '=', $id)->select('processo.*')->with('pessoa')->first();
        return view('processos.visualizar', ['processo' => $processo]);
    }

    public function update($id, Request $request) {
        if ($request->is('admin/*')) {
            $processo = Processo::join('pessoa', 'processo.id_pessoa', '=', 'pessoa.id')->where('pessoa.id_usuario', '=', Auth::user()->id)->where('processo.id', '=', $id)->select('processo.*')->with('pessoa')->first();
        }else{
            $processo = Processo::where('id', '=', $id)->first();
        }
        
        $resposta = new ProcessoResposta;
        $request->merge(['id_usuario' => Auth::user()->id, 'id_processo' => $id]);
        if ($request->file('guia')) {
            $guia = $request->file('guia');
            $guia_nome = 'processo_guia' . str_shuffle(date('dmyhis')) . '.' . $guia->guessClientExtension();
            $guia->move(getcwd() . '/uploads/guias/', $guia_nome);
            $request->merge(['guia' => $guia_nome]);
            $processo->guia = $guia_nome;
            $processo->save();
        }
        if ($request->file('anexo')) {
            $anexo = $request->file('anexo');
            $anexo_nome = 'processo_anexo' . str_shuffle(date('dmyhis')) . '.' . $anexo->guessClientExtension();
            $anexo->move(getcwd() . '/uploads/processos/', $anexo_nome);
            $request->merge(['anexo' => $anexo_nome]);
        }
        if ($resposta->validate($request->all())) {
            $resposta->create($request->all());
            if ($request->get('status')) {
                $processo->status = $request->get('status');
                $processo->save();
            }
            if ($request->is('admin/*')) {
                return redirect(route('visualizar-processos', $id));
            }
            return redirect(route('responder-processo-usuario', $id));
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
