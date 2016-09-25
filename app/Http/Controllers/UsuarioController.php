<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Usuario;

class UsuarioController extends Controller {

    public function edit() {
        $usuario = Auth::user();
        return view('usuario.editar', ['usuario' => $usuario]);
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
