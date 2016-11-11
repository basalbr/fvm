<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\NaturezaJuridica;
use Illuminate\Http\Request;

class NaturezaJuridicaController extends Controller {

    public function index() {
        $naturezas_juridicas = NaturezaJuridica::orderBy('descricao', 'asc')->paginate(10);
        return view('admin.natureza_juridica.index', ['naturezas_juridicas' => $naturezas_juridicas]);
    }

    public function create() {
        return view('admin.natureza_juridica.cadastrar');
    }

    public function store(Request $request) {
        $natureza_juridica = new NaturezaJuridica;
        if ($natureza_juridica->validate($request->all())) {
            $natureza_juridica->create($request->all());
            return redirect(route('listar-natureza-juridica'));
        } else {
            return redirect(route('cadastrar-natureza-juridica'))->withInput()->withErrors($natureza_juridica->errors());
        }
    }

    public function edit($id) {
        $natureza_juridica = NaturezaJuridica::where('id', '=', $id)->first();
        return view('admin.natureza_juridica.editar', ['natureza_juridica' => $natureza_juridica]);
    }

    public function update($id, Request $request) {
        $natureza_juridica = NaturezaJuridica::where('id', '=', $id)->first();
        if ($natureza_juridica->validate($request->all())) {
            $natureza_juridica->update($request->all());
            return redirect(route('listar-natureza-juridica'));
        } else {
            return redirect(route('editar-natureza-juridica'))->withInput()->withErrors($natureza_juridica->errors());
        }
    }

}
