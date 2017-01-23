<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TipoAlteracao;
use App\AlteracaoCampo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AlteracaoCampoController extends Controller {

    public function index($id) {
        $campos = AlteracaoCampo::where('id_tipo_alteracao', '=', $id)->get();
        return view('admin.tipo_alteracao.campos.index', ['campos' => $campos, 'id_alteracao'=>$id]);
    }

    public function create() {
        return view('admin.tipo_alteracao.campos.cadastrar');
    }

    public function store($id, Request $request) {
        $campo = new AlteracaoCampo;
        $request->merge(['id_tipo_alteracao'=>$id]);
        if ($campo->validate($request->all())) {
            $campo->create($request->all());
            return redirect(route('listar-campo-alteracao',[$id]));
        } else {
            return redirect(route('cadastrar-campo-alteracao',[$id]))->withInput()->withErrors($campo->errors());
        }
    }

    public function edit($id, $id_campo) {
        $campo = AlteracaoCampo::where('id', '=', $id_campo)->first();
        return view('admin.tipo_alteracao.campos.editar', ['campo' => $campo]);
    }

    public function update($id, $id_campo, Request $request) {
        $campo = AlteracaoCampo::where('id', '=', $id_campo)->first();
        $request->merge(['id_tipo_alteracao'=>$id]);
        if ($campo->validate($request->all())) {
            $campo->update($request->all());
            return redirect(route('listar-campo-alteracao',[$id]));
        } else {
            return redirect(route('editar-campo-alteracao',[$id, $id_campo]))->withInput()->withErrors($campo->errors());
        }
    }

}
