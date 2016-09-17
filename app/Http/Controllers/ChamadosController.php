<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Chamado;
use App\ChamadoResposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ChamadosController extends Controller {

    public function index() {
        $chamados = Chamado::orderBy('updated_at', 'desc')->get();
        return view('admin.chamados.index', ['chamados' => $chamados]);
    }

    public function indexUsuario() {
        $chamados = Chamado::query();
        $chamados->where('id_usuario', '=', Auth::user()->id);
        if (Input::get('de')) {
            $data = explode('/', Input::get('de'));
            $data = $data[2].'-'.$data[1].'-'.$data[0];
            $chamados->where('created_at', '>=', $data);
        }
        if (Input::get('ate')) {
            $data = explode('/', Input::get('ate'));
            $data = $data[2].'-'.$data[1].'-'.$data[0];
            $chamados->where('created_at', '<=', $data);
        }
        if (Input::get('titulo')) {
            $chamados->where('titulo', 'like', '%' . Input::get('titulo') . '%');
        }
        if (Input::get('status')) {
            $chamados->where('status', '=',Input::get('status'));
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'atualizado_desc') {
                $chamados->orderBy('updated_at', 'desc');
            }
            if (Input::get('ordenar') == 'atualizado_asc') {
                $chamados->orderBy('updated_at', 'asc');
            }
            if (Input::get('ordenar') == 'titulo_desc') {
                $chamados->orderBy('titulo', 'desc');
            }
            if (Input::get('ordenar') == 'titulo_asc') {
                $chamados->orderBy('titulo', 'asc');
            }
        }else{
            $chamados->orderBy('updated_at','desc');
        }
        $chamados->paginate(10);
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
            $chamado = Chamado::where('id', '=', $id)->first()->touch();
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
