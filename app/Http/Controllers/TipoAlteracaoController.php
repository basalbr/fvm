<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TipoAlteracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class TipoAlteracaoController extends Controller {

    public function index() {
       
        $tipos_alteracao = TipoAlteracao::get();
        return view('admin.tipo_alteracao.index', ['tipos_alteracao' => $tipos_alteracao]);
    }

    public function create() {
        return view('admin.tipo_alteracao.cadastrar');
    }

    public function store(Request $request) {
        $tipo_alteracao = new TipoAlteracao;
        $request->merge(['valor' => str_replace(',', '.', preg_replace('#[^\d\,]#is', '', $request->get('valor')))]);
        if ($tipo_alteracao->validate($request->all())) {
            $tipo_alteracao->create($request->all());
            return redirect(route('listar-tipo-alteracao'));
        } else {
            return redirect(route('cadastrar-tipo-alteracao'))->withInput()->withErrors($tipo_alteracao->errors());
        }
    }

    public function edit($id) {
        $tipo_alteracao = TipoAlteracao::where('id', '=', $id)->first();
        return view('admin.tipo_alteracao.editar', ['tipo_alteracao' => $tipo_alteracao]);
    }

    public function update($id, Request $request) {
        $tipo_alteracao = TipoAlteracao::where('id', '=', $id)->first();
        $request->merge(['valor' => str_replace(',', '.', preg_replace('#[^\d\,]#is', '', $request->get('valor')))]);
        if ($tipo_alteracao->validate($request->all())) {
            $tipo_alteracao->update($request->all());
            return redirect(route('listar-tipo-alteracao'));
        } else {
            return redirect(route('editar-tipo-alteracao'))->withInput()->withErrors($tipo_alteracao->errors());
        }
    }

}
