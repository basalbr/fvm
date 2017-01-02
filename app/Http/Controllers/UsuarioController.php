<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use Illuminate\Support\Facades\Input;

class UsuarioController extends Controller {

    public function edit() {
        $usuario = Auth::user();
        return view('usuario.editar', ['usuario' => $usuario]);
    }

    public function editAdmin($id) {
        $usuario = Usuario::where('id', '=', $id)->first();
        return view('admin.usuarios.editar', ['usuario' => $usuario]);
    }

    public function index() {
        $usuarios = Usuario::query();
        if (Input::get('nome')) {
            $usuarios->where('nome', 'like', '%' . Input::get('nome') . '%');
        }
        if (Input::get('email')) {
            $usuarios->where('email', 'like', '%' . Input::get('email') . '%');
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'nome_asc') {
                $usuarios->orderBy('nome', 'asc');
            }
            if (Input::get('ordenar') == 'nome_desc') {
                $usuarios->orderBy('nome', 'desc');
            }
            if (Input::get('ordenar') == 'email_asc') {
                $usuarios->orderBy('email', 'asc');
            }
            if (Input::get('ordenar') == 'email_desc') {
                $usuarios->orderBy('email', 'desc');
            }
            if (Input::get('ordenar') == 'cadastrado_asc') {
                $usuarios->orderBy('created_at', 'asc');
            }
            if (Input::get('ordenar') == 'cadastrado_desc') {
                $usuarios->orderBy('created_at', 'desc');
            }
        } else {
            $usuarios->orderBy('nome', 'asc');
        }
        $usuarios = $usuarios->paginate(10);
        return view('admin.usuarios.index', ['usuarios' => $usuarios]);
    }

    public function update(Request $request) {
        $usuario = Usuario::findOrFail(Auth::user()->id);
        $request->merge(['id' => $usuario->id]);

        if ($usuario->validate($request->all(), true)) {
            if ($request->get('senha') == '') {
                $usuario->update($request->except('senha'));
            } else {
                $nova_senha = \Illuminate\Support\Facades\Hash::make($request->get('senha'));
                $request->merge(['senha' => $nova_senha]);
                $usuario->update($request->all());
            }
            return redirect(route('editar-usuario'));
        } else {
            return redirect(route('editar-usuario'))->withInput()->withErrors($usuario->errors());
        }
    }

}
