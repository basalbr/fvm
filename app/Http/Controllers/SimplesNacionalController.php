<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TabelaSimplesNacional;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class SimplesNacionalController extends Controller {

    public function index() {
        $tabelas = TabelaSimplesNacional::orderBy('descricao', 'asc')->paginate(10);
        return view('admin.simples_nacional.index', ['tabelas' => $tabelas]);
    }

    public function create() {
        return view('admin.simples_nacional.cadastrar');
    }

    public function store(Request $request) {
        $tbn = new TabelaSimplesNacional;
        if ($tbn->validate($request->only('descricao'))) {
            $tbn->create($request->only('descricao'));
            return redirect(route('listar-simples-nacional'));
        } else {
            return redirect(route('cadastrar-simples-nacional'))->withInput()->withErrors($tbn->errors());
        }
    }

    public function edit($id) {
        $tabela = TabelaSimplesNacional::where('id', '=', $id)->first();
        return view('admin.simples_nacional.editar', ['tabela' => $tabela]);
    }

    public function update($id, Request $request) {
        $tbn = TabelaSimplesNacional::where('id', '=', $id)->first();
        if ($tbn->validate($request->only('descricao'))) {
            $tbn->update($request->only('descricao'));
            return redirect(route('listar-simples-nacional'));
        } else {
            return redirect(route('editar-simples-nacional'))->withInput()->withErrors($tbn->errors());
        }
    }

}
