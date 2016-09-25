<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Plano;
use Illuminate\Http\Request;

class PlanoController extends Controller {

    public function index() {
        $planos = Plano::orderBy('descricao', 'asc')->paginate(5);
        return view('admin.plano.index', ['planos' => $planos]);
    }

    public function create() {
        return view('admin.plano.cadastrar');
    }

    public function store(Request $request) {
        $plano = new Plano;
        $request->merge(['valor' => str_replace(',', '.', preg_replace('#[^\d\,]#is', '', $request->get('valor')))]);
        if ($plano->validate($request->all())) {
            $plano->create($request->all());
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
        $request->merge(['valor' => str_replace(',', '.', preg_replace('#[^\d\,]#is', '', $request->get('valor')))]);
        if ($plano->validate($request->all())) {
            $plano->update($request->all());
            return redirect(route('listar-plano'));
        } else {
            return redirect(route('editar-plano'))->withInput()->withErrors($plano->errors());
        }
    }

    public function simular() {
        $planos = Plano::orderBy('total_documentos','asc')->get();
        $max_documentos = Plano::max('total_documentos');
        $max_contabeis = Plano::max('total_documentos');
        $max_pro_labores = Plano::max('pro_labores');
        $max_valor = Plano::max('valor');
        $min_valor = Plano::min('valor');
        return response()->json(['planos' => $planos, 'max_documentos' => (int)$max_documentos, 'max_pro_labores' => (int)$max_pro_labores, 'max_valor' => (float)$max_valor, 'min_valor' => (int)$min_valor,'max_contabeis'=>(int)$max_contabeis]);
    }

}
