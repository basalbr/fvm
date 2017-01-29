<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\ProcessoDocumentoContabil;

class ProcessoDocumentoContabilController extends Controller {

    public function abreProcessos() {
        $pessoas = \App\Pessoa::all();
        foreach ($pessoas as $pessoa) {
            $pessoa->abrir_processos_contabeis();
        }
    }

    public function index() {
        $processos = ProcessoDocumentoContabil::query();
        $processos = $processos->paginate(10);

        return view('documentos_contabeis.index', ['processos' => $processos]);
    }

    public function indexAdmin() {

        $processos = ProcessoDocumentoContabil::query();
        $processos->join('pessoa', 'pessoa.id', '=', 'processo_documento_contabil.id_pessoa');
        if (Input::get('periodo_de')) {
            $data = explode('/', Input::get('periodo_de'));
            $data = $data[2] . '-' . $data[1] . '-' . '01';
            $processos->where('processo_documento_contabil.periodo', '>=', $data);
        }
        if (Input::get('periodo_ate')) {
            $data = explode('/', Input::get('periodo_ate'));
            $data = $data[2] . '-' . $data[1] . '-' . '01';
            $processos->where('processo_documento_contabil.periodo', '<=', $data);
        }

        if (Input::get('empresa')) {
            $processos->where('pessoa.nome_fantasia', 'LIKE', '%' . Input::get('empresa') . '%');
        }
        if (Input::get('status')) {
            $processos->where('processo_documento_contabil.status', '=', Input::get('status'));
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'periodo_desc') {
                $processos->orderBy('processo_documento_contabil.periodo', 'desc');
            }
            if (Input::get('ordenar') == 'periodo_asc') {
                $processos->orderBy('processo_documento_contabil.periodo', 'asc');
            }
            if (Input::get('ordenar') == 'atualizado_desc') {
                $processos->orderBy('processo_documento_contabil.updated_at', 'desc');
            }
            if (Input::get('ordenar') == 'atualizado_asc') {
                $processos->orderBy('processo_documento_contabil.updated_at', 'asc');
            }
        } else {
            $processos->orderBy('processo_documento_contabil.periodo', 'desc')->orderBy('processo_documento_contabil.updated_at');
        }
        $processos->select('processo_documento_contabil.*');
        $processos = $processos->paginate(15);

        return view('admin.documentos_contabeis.index', ['processos' => $processos]);
    }

    public function semMovimento($id) {
        $processo = ProcessoDocumentoContabil::join('pessoa', 'pessoa.id', '=', 'processo_documento_contabil.id_pessoa')
                ->where('pessoa.id_usuario', '=', Auth::user()->id)
                ->where('processo_documento_contabil.id', '=', $id)
                ->select('processo_documento_contabil.*')
                ->first();
        $processo->status = 'sem_movimento';
        $processo->save();
        $processo->enviar_novo_status();
        return response()->redirectTo(route('listar-processo-documento-contabil'));
    }

    public function mudarStatus($id) {
        $processo = ProcessoDocumentoContabil::find($id);
        $processo->status = 'contabilizado';
        $processo->save();
        $processo->enviar_novo_status();
        return response()->redirectTo(route('listar-processo-documento-contabil-admin'));
    }

}
