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
        $chamados = $chamados->paginate(10);
        return view('chamados.index', ['chamados' => $chamados]);
    }

    public function create() {
        return view('chamados.cadastrar');
    }

    public function store(Request $request) {
        $chamado = new Chamado;

        $request->merge(['id_usuario' => Auth::user()->id]);
        if ($chamado->validate($request->only('titulo', 'mensagem', 'id_usuario'))) {
            $chamado = $chamado->create($request->only('titulo', 'mensagem', 'id_usuario'));
            $chamado_resposta = new ChamadoResposta;
            $chamado_resposta->id_chamado = $chamado->id;
            $chamado_resposta->id_usuario = Auth::user()->id;
            $chamado_resposta->mensagem = $request->get('mensagem');
            if ($request->file('anexo')) {
                $anexo = date('dmyhis') . '.' . $request->file('anexo')->guessClientExtension();
                $request->file('anexo')->move(getcwd() . '/uploads/chamados/', $anexo);
                $chamado_resposta->anexo = $anexo;
            }
            $chamado_resposta->save();
            return redirect(route('listar-chamados-usuario'));
        } else {
            return redirect(route('cadastrar-chamado'))->withInput()->withErrors($chamado->errors());
        }
    }

    public function edit($id) {
        $chamado = Chamado::where('id', '=', $id)->where('id_usuario','=',Auth::user()->id)->first();
        return view('chamados.visualizar', ['chamado' => $chamado]);
    }
    
    public function editAdmin($id) {
        $chamado = Chamado::where('id', '=', $id)->first();
        return view('admin.chamados.visualizar', ['chamado' => $chamado]);
    }

    public function update($id, Request $request) {
        $resposta = new ChamadoResposta;
        $request->merge(['id_usuario' => Auth::user()->id]);
        $request->merge(['id_chamado' => $id]);
        if ($resposta->validate($request->all())) {
            if ($request->file('arquivo')) {
                $anexo = date('dmyhis') . '.' . $request->file('arquivo')->guessClientExtension();
                $request->file('arquivo')->move(getcwd() . '/uploads/chamados/', $anexo);
                $request->merge(['anexo'=>$anexo]);
            }
            
            $resposta->create($request->all());
            $chamado = Chamado::where('id', '=', $id)->first();
            $chamado->touch();
            if($request->get('status')){
                $chamado->status = $request->get('status');
                $chamado->save();
            }
            if ($request->is('admin/*')) {
                return redirect(route('visualizar-chamados', $id));
            }
            return redirect(route('responder-chamado-usuario', $id));
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
