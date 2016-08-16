<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Cnae;
use Illuminate\Http\Request;

class CnaeController extends Controller {

    public function index() {
        $cnaes = Cnae::orderBy('descricao', 'asc')->paginate(15);
        return view('admin.cnae.index', ['cnaes' => $cnaes]);
    }

    public function create() {
        $tabelas = \App\TabelaSimplesNacional::orderBy('descricao', 'asc')->get();
        return view('admin.cnae.cadastrar', ['tabelas' => $tabelas]);
    }

    public function store(Request $request) {
        $cnae = new Cnae;
        if ($cnae->validate($request->only('id_tabela_simples_nacional', 'descricao', 'codigo'))) {
            $cnae->create($request->only('id_tabela_simples_nacional', 'descricao', 'codigo'));
            return redirect(route('listar-cnae'));
        } else {
            return redirect(route('cadastrar-cnae'))->withInput()->withErrors($cnae->errors());
        }
    }

    public function edit($id) {
        $tabelas = \App\TabelaSimplesNacional::orderBy('descricao', 'asc')->get();
        $cnae = Cnae::where('id', '=', $id)->first();
        return view('admin.cnae.editar', ['cnae' => $cnae, 'tabelas' => $tabelas]);
    }

    public function update($id, Request $request) {
        $cnae = Cnae::where('id', '=', $id)->first();
        if ($cnae->validate($request->only('id_tabela_simples_nacional', 'descricao', 'codigo'))) {
            $cnae->update($request->only('id_tabela_simples_nacional', 'descricao', 'codigo'));
            return redirect(route('listar-cnae'));
        } else {
            return redirect(route('editar-cnae'))->withInput()->withErrors($cnae->errors());
        }
    }
    
    public function ajax(Request $request){
        if($request->get('tipo') == 'descricao'){
        $lista = Cnae::where('descricao','ilike','%'.$request->get('search').'%')->orderBy('descricao')->take(5)->get(['descricao','codigo','id']);
        }else{
            $lista = Cnae::where('codigo','ilike','%'.$request->get('search').'%')->orderBy('descricao')->take(5)->get(['descricao','codigo','id']);
        }
        return response()->json($lista);
    }

}
