<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imposto;
use Illuminate\Http\Request;

class ImpostoController extends Controller {

    public function index() {
        $tabelas = Imposto::orderBy('nome', 'asc')->get();
        return view('admin.imposto.index', ['tabelas' => $tabelas]);
    }

    public function create() {
        return view('admin.imposto.cadastrar');
    }

    public function store(Request $request) {
        $tbn = new Imposto;
        if ($tbn->validate($request->only('nome'))) {
            $tbn->create($request->only('nome'));
            return redirect(route('listar-imposto'));
        } else {
            return redirect(route('cadastrar-imposto'))->withInput()->withErrors($tbn->errors());
        }
    }

    public function edit($id) {
        $tabela = Imposto::where('id', '=', $id)->first();
        return view('admin.imposto.editar', ['tabela' => $tabela]);
    }

    public function update($id, Request $request) {
        $tbn = Imposto::where('id', '=', $id)->first();
        if ($tbn->validate($request->only('nome'))) {
            $tbn->update($request->only('nome'));
            return redirect(route('listar-imposto'));
        } else {
            return redirect(route('editar-imposto'))->withInput()->withErrors($tbn->errors());
        }
    }

}
