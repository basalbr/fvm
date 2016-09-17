<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Socio;
use App\Pessoa;
use Illuminate\Http\Request;

class SocioController extends Controller {

    public function index($id_empresa) {
        $socios = Socio::where('id_pessoa','=',$id_empresa)->orderBy('nome', 'asc')->get();
        $empresa = Pessoa::where('id','=',$id_empresa)->first()->nome_fantasia;
        return view('empresa.socios.index', ['socios' => $socios,'id_empresa'=>$id_empresa,'empresa'=>$empresa]);
    }

    public function create($id_empresa) {
        return view('empresa.socios.cadastrar',['id_empresa'=>$id_empresa]);
    }

    public function store($id_empresa, Request $request) {
        $socio = new Socio;
        if ($socio->validate($request->all())) {
            $socio->create($request->all());
            return redirect(route('listar-socios',[$id_empresa]));
        } else {
            return redirect(route('cadastrar-socio',[$id_empresa]))->withInput()->withErrors($socio->errors());
        }
    }

    public function edit($id_empresa, $id) {
        $socio = Socio::where('id', '=', $id)->where('id_pessoa','=',$id_empresa)->first();
        return view('empresa.socios.editar', ['socio' => $socio]);
    }

    public function update($id_empresa, $id, Request $request) {
        $socio = Socio::where('id', '=', $id)->where('id_pessoa','=',$id_empresa)->first();
        if ($socio->validate($request->all())) {
            $socio->update($request->all());
            return redirect(route('listar-socios',[$id_empresa]));
        } else {
            return redirect(route('editar-socio',[$id_empresa]))->withInput()->withErrors($socio->errors());
        }
    }

}
