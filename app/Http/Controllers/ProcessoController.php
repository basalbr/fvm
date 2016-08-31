<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Chamado;
use App\ChamadoResposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcessoController extends Controller {

    public function index() {
        $processos = Chamado::orderBy('updated_at', 'desc')->get();
        return view('admin.processos.index', ['processos' => $processos]);
    }

    public function indexUsuario() {
        $processos = Chamado::where('id_usuario', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        return view('processos.index', ['processos' => $processos]);
    }

    public function create(Request $request) {
        $imposto = \App\Imposto::where('id','=',$request->get('id_imposto'))->first();
        $empresa = \App\Pessoa::where('cpf_cnpj', '=',$request->get('cnpj'))->where('id_usuario', '=', Auth::user()->id)->first();
        return view('processos.cadastrar', ['competencia'=>$request->get('competencia'), 'empresa'=>$empresa, 'vencimento'=>$request->get('vencimento'), 'imposto'=>$imposto]);
    }

    public function store(Request $request) {
        $processo = new Chamado;

        $request->merge(['id_usuario' => Auth::user()->id]);
        if ($processo->validate($request->only('titulo', 'mensagem', 'id_usuario'))) {
            $processo->create($request->only('titulo', 'mensagem', 'id_usuario'));
            return redirect(route('listar-processos-usuario'));
        } else {
            return redirect(route('cadastrar-processo'))->withInput()->withErrors($processo->errors());
        }
    }

    public function edit($id) {
        $processo = Chamado::where('id', '=', $id)->first();
        return view('processos.visualizar', ['processo' => $processo]);
    }

    public function update($id, Request $request) {
        $resposta = new ChamadoResposta;
        $request->merge(['id_usuario' => Auth::user()->id]);
        $request->merge(['id_processo' => $id]);
        if ($resposta->validate($request->only('mensagem'))) {
            $resposta->create($request->only('mensagem', 'id_usuario', 'id_processo'));
            if ($request->is('admin/*')) {
                return redirect(route('listar-processos'));
            }
            return redirect(route('listar-processos-usuario'));
        } else {
            if ($request->is('admin/*')) {
                return redirect(route('visualizar-processos', $id))->withInput()->withErrors($resposta->errors());
            }
            return redirect(route('responder-processo-usuario', $id))->withInput()->withErrors($resposta->errors());
        }
    }

    public function ajax(Request $request) {
        $lista = Chamado::where('descricao', 'ilike', '%' . $request->get('search') . '%')->orWhere('codigo', 'ilike', '%' . $request->get('search') . '%')->orderBy('descricao')->take(5)->get(['descricao', 'codigo']);
        return response()->json($lista);
    }

}
