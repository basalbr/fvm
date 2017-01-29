<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TipoDocumentoContabil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class TipoDocumentoContabilController extends Controller {

    public function index() {
        $tipo_documentos = TipoDocumentoContabil::orderBy('descricao')->get();
        return view('admin.tipo_documento_contabil.index', ['tipos_documentos' => $tipo_documentos]);
    }

    public function create() {
        return view('admin.tipo_documento_contabil.cadastrar');
    }

    public function store(Request $request) {
        $tipo_documento_contabil = new TipoDocumentoContabil;
        if ($tipo_documento_contabil->validate($request->all())) {
            $tipo_documento_contabil->create($request->all());
            return redirect(route('listar-tipo-documento-contabil'));
        } else {
            return redirect(route('cadastrar-tipo-documento-contabil'))->withInput()->withErrors($tbn->errors());
        }
    }

    public function edit($id) {
        $tipo_documento_contabil = TipoDocumentoContabil::where('id', '=', $id)->first();
        return view('admin.tipo_documento_contabil.editar', ['tipo_documento_contabil' => $tipo_documento_contabil]);
    }

    public function update($id, Request $request) {
         $tipo_documento_contabil = TipoDocumentoContabil::where('id', '=', $id)->first();
        if ($tipo_documento_contabil->validate($request->all())) {
            $tipo_documento_contabil->create($request->all());
            return redirect(route('listar-tipo-documento-contabil'));
        } else {
            return redirect(route('editar-tipo-documento-contabil',[$id]))->withInput()->withErrors($tbn->errors());
        }
    }

    public function ajax(Request $request) {
        $lista = Processo::where('descricao', 'ilike', '%' . $request->get('search') . '%')->orWhere('codigo', 'ilike', '%' . $request->get('search') . '%')->orderBy('descricao')->take(5)->get(['descricao', 'codigo']);
        return response()->json($lista);
    }

}
