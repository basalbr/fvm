<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Plano;
use Illuminate\Http\Request;

class PlanoController extends Controller {

    public function index() {
        $planos = Plano::orderBy('descricao', 'asc')->get();
        return view('admin.plano.index', ['planos' => $planos]);
    }

    public function create() {
        return view('admin.plano.cadastrar');
    }

    public function store(Request $request) {
        $plano = new Plano;
        if ($plano->validate($request->only('duracao', 'valor', 'nome', 'descricao'))) {
            $plano->create($request->only('duracao', 'valor', 'nome', 'descricao'));
            return redirect(route('listar-plano'));
        } else {
            return redirect(route('cadastrar-plano'))->withInput()->withErrors($plano->errors());
        }
    }

    public function edit($id) {
        $plano = Plano::where('id', '=', $id)->first();
        return view('admin.plano.editar', ['plano' => $plano]);
    }

    public function update($id, Request $request) {
        $plano = Plano::where('id', '=', $id)->first();
        if ($plano->validate($request->only('duracao', 'valor', 'nome', 'descricao'))) {
            $plano->update($request->only('duracao', 'valor', 'nome', 'descricao'));
            return redirect(route('listar-plano'));
        } else {
            return redirect(route('editar-plano'))->withInput()->withErrors($plano->errors());
        }
    }

}
