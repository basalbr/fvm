<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TipoTributacao;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class TipoTributacaoController extends Controller {

    public function index() {
        $tipo_tributacao = TipoTributacao::orderBy('descricao', 'asc')->paginate(10);
        return view('admin.tipo_tributacao.index', ['tipo_tributacao' => $tipo_tributacao]);
    }

    public function create() {
        return view('admin.tipo_tributacao.cadastrar');
    }

    public function store(Request $request) {
        $tbn = new TipoTributacao;
        if ($tbn->validate($request->only('descricao', 'has_tabela'))) {
            $tbn->create($request->only('descricao', 'has_tabela'));
            return redirect(route('listar-tipo-tributacao'));
        } else {
            return redirect(route('cadastrar-tipo-tributacao'))->withInput()->withErrors($tbn->errors());
        }
    }

    public function edit($id) {
        $tabela = TipoTributacao::where('id', '=', $id)->first();
        return view('admin.tipo_tributacao.editar', ['tabela' => $tabela]);
    }

    public function update($id, Request $request) {
        $tipo_tributacao = TipoTributacao::where('id', '=', $id)->first();
        if ($tipo_tributacao->validate($request->only('descricao','has_tabela'))) {
            $tipo_tributacao->update($request->only('descricao','has_tabela'));
            return redirect(route('listar-tipo-tributacao'));
        } else {
            return redirect(route('editar-tipo-tributacao'))->withInput()->withErrors($tipo_tributacao->errors());
        }
    }

}
