<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Socio;
use App\Pessoa;
use Illuminate\Http\Request;

class SocioController extends Controller {

    public function index($id_empresa) {
        $socios = Socio::where('id_pessoa', '=', $id_empresa)->orderBy('nome', 'asc')->get();
        $empresa = Pessoa::where('id', '=', $id_empresa)->first()->nome_fantasia;
        return view('empresa.socios.index', ['socios' => $socios, 'id_empresa' => $id_empresa, 'empresa' => $empresa]);
    }

    public function indexSocios() {
        $socios = Socio::join('pessoa', 'pessoa.id', '=', 'socio.id_pessoa')->where('pessoa.id_usuario', '=', Auth::user()->id)->orderBy('socio.id_pessoa')->select('socio.*')->paginate(10);
        return view('socios.index', ['socios' => $socios]);
    }

    public function create($id_empresa) {
        return view('empresa.socios.cadastrar', ['id_empresa' => $id_empresa]);
    }

    public function store($id_empresa, Request $request) {
        $socio = new Socio;
        if ($socio->validate($request->all())) {
            $socio->create($request->all());
            return redirect(route('listar-socios', [$id_empresa]));
        } else {
            return redirect(route('cadastrar-socio', [$id_empresa]))->withInput()->withErrors($socio->errors());
        }
    }

    public function edit($id_empresa, $id) {
        $socio = Socio::where('id', '=', $id)->where('id_pessoa', '=', $id_empresa)->first();
        return view('empresa.socios.editar', ['socio' => $socio]);
    }

    public function update($id_empresa, $id, Request $request) {
        if ($request->get('pro_labore')) {
            $request->merge(['pro_labore'=>str_replace(',','.',preg_replace('#[^\d\,]#is','',$request->get('pro_labore')))]);
        }
        $socio = Socio::where('id', '=', $id)->where('id_pessoa', '=', $id_empresa)->first();
        $request->merge(['id'=>$socio->id]);
        if ($socio->validate($request->all(), true)) {
            $socio->update($request->all());
            return redirect(route('listar-socios', [$id_empresa, $id]));
        } else {
            return redirect(route('editar-socio', [$id_empresa, $id]))->withInput()->withErrors($socio->errors());
        }
    }

}
