<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Cnae;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CnaeController extends Controller {

    public function index() {
        $cnaes = Cnae::query();
        $cnaes->join('tabela_simples_nacional', 'tabela_simples_nacional.id', '=', 'cnae.id_tabela_simples_nacional');
        if (Input::get('descricao')) {
            $cnaes->where('cnae.descricao', 'like', '%' . Input::get('descricao') . '%');
        }
        if (Input::get('codigo')) {
            $cnaes->where('cnae.codigo', 'like', '%' . Input::get('codigo') . '%');
        }
        if (Input::get('tabela')) {
            $cnaes->where('tabela_simples_nacional.descricao', '=', Input::get('tabela'));
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'descricao_desc') {
                $cnaes->orderBy('cnae.descricao', 'desc');
            }
            if (Input::get('ordenar') == 'descricao_asc') {
                $cnaes->orderBy('cnae.descricao', 'asc');
            }
            if (Input::get('ordenar') == 'codigo_desc') {
                $cnaes->orderBy('cnae.codigo', 'desc');
            }
            if (Input::get('ordenar') == 'codigo_asc') {
                $cnaes->orderBy('cnae.codigo', 'asc');
            }
            if (Input::get('ordenar') == 'tabela') {
                $cnaes->orderBy('tabela_simples_nacional.descricao', 'desc');
            }
            if (Input::get('ordenar') == 'tabela') {
                $cnaes->orderBy('tabela_simples_nacional.descricao', 'asc');
            }
        } else {
            $cnaes->orderBy('cnae.descricao', 'asc');
        }
        $cnaes = $cnaes->select('cnae.*')->paginate(10);
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

    public function ajax(Request $request) {
        if ($request->get('tipo') == 'descricao') {
            $lista = Cnae::where('descricao', 'like', '%' . $request->get('search') . '%')->orderBy('descricao')->take(5)->get(['descricao', 'codigo', 'id']);
        } else {
            $lista = Cnae::where('codigo', 'like', '%' . $request->get('search') . '%')->orderBy('descricao')->take(5)->get(['descricao', 'codigo', 'id']);
        }
        return response()->json($lista);
    }

}
