<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Chamado;
use App\ChamadoResposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamadosController extends Controller {

    public function index() {
        $chamados = Chamado::orderBy('updated_at', 'desc')->get();
        return view('admin.chamados.index', ['chamados' => $chamados]);
    }

    public function indexUsuario() {
        $chamados = Chamado::where('id_usuario', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        return view('chamados.index', ['chamados' => $chamados]);
    }

    public function create() {
        return view('chamados.cadastrar');
    }

    public function store(Request $request) {
        $chamado = new Chamado;

        $request->merge(['id_usuario' => Auth::user()->id]);
        if ($chamado->validate($request->only('titulo', 'mensagem', 'id_usuario'))) {
            $chamado->create($request->only('titulo', 'mensagem', 'id_usuario'));
            return redirect(route('listar-chamados-usuario'));
        } else {
            return redirect(route('cadastrar-chamado'))->withInput()->withErrors($chamado->errors());
        }
    }

    public function edit($id) {
        $chamado = Chamado::where('id', '=', $id)->first();
        return view('chamados.visualizar', ['chamado' => $chamado]);
    }

    public function update($id, Request $request) {
        $resposta = new ChamadoResposta;
        $request->merge(['id_usuario' => Auth::user()->id]);
        $request->merge(['id_chamado' => $id]);
        if ($resposta->validate($request->only('mensagem'))) {
            $resposta->create($request->only('mensagem', 'id_usuario', 'id_chamado'));
            if ($request->is('admin/*')) {
                return redirect(route('listar-chamados'));
            }
            return redirect(route('listar-chamados-usuario'));
        } else {
            if ($request->is('admin/*')) {
                return redirect(route('visualizar-chamados', $id))->withInput()->withErrors($resposta->errors());
            }
            return redirect(route('responder-chamado-usuario', $id))->withInput()->withErrors($resposta->errors());
        }
    }

    public function ajax(Request $request) {
        $lista = Chamado::where('descricao', 'ilike', '%' . $request->get('search') . '%')->orWhere('codigo', 'ilike', '%' . $request->get('search') . '%')->orderBy('descricao')->take(5)->get(['descricao', 'codigo']);
        return response()->json($lista);
    }

}
