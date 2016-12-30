<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mensalidade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class MensalidadeController extends Controller {

    public function abrePagamentos() {
        $mensalidades = \App\Mensalidade::all();
        foreach ($mensalidades as $mensalidade) {
            $mensalidade->abrir_ordem_pagamento();
        }
    }

    public function index() {
        $mensalidades = Mensalidade::where('id_usuario', '=', Auth::user()->id)->get();
        return view('mensalidades.index', ['mensalidades' => $mensalidades]);
    }

    public function indexAdmin() {
        $mensalidades = Mensalidade::query();
        $mensalidades->join('usuario', 'usuario.id', '=', 'mensalidade.id_usuario');
        $mensalidades->join('pessoa', 'pessoa.id', '=', 'mensalidade.id_pessoa');
        $mensalidades->where('pessoa.status', '=', 'Aprovado');
        if (Input::get('usuario')) {
            $mensalidades->where('usuario.nome', 'like', '%' . Input::get('usuario') . '%');
        }
        if (Input::get('nome_fantasia')) {
            $mensalidades->where('pessoa.nome_fantasia', 'like', '%' . Input::get('nome_fantasia') . '%');
        }
        if (Input::get('razao_social')) {
            $mensalidades->where('pessoa.razao_social', 'like', '%' . Input::get('razao_social') . '%');
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'usuario_asc') {
                $mensalidades->orderBy('usuario.nome', 'asc');
            }
            if (Input::get('ordenar') == 'usuario_desc') {
                $mensalidades->orderBy('usuario.nome', 'desc');
            }
            if (Input::get('ordenar') == 'razao_social_asc') {
                $mensalidades->orderBy('pessoa.razao_social', 'asc');
            }
            if (Input::get('ordenar') == 'razao_social_desc') {
                $mensalidades->orderBy('pessoa.razao_social', 'desc');
            }
            if (Input::get('ordenar') == 'nome_fantasia_asc') {
                $mensalidades->orderBy('pessoa.nome_fantasia', 'asc');
            }
            if (Input::get('ordenar') == 'nome_fantasia_desc') {
                $mensalidades->orderBy('pessoa.nome_fantasia', 'desc');
            }
        } else {
            $mensalidades->orderBy('pessoa.nome_fantasia', 'asc');
        }
        $mensalidades = $mensalidades->select('mensalidade.*')->paginate(5);
        return view('admin.mensalidades.index', ['mensalidades' => $mensalidades]);
    }

}
