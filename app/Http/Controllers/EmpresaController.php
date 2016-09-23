<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller {

    public function index() {
        $empresas = \App\Pessoa::where('id_usuario', '=', Auth::user()->id)->orderBy('nome_fantasia')->get();
        return view('empresa.index', ['empresas' => $empresas]);
    }

    public function create() {
        $tipoTributacoes = \App\TipoTributacao::orderBy('descricao', 'asc')->get();
        $naturezasJuridicas = \App\NaturezaJuridica::orderBy('descricao', 'asc')->get();
        return view('empresa.cadastrar', [ 'tipoTributacoes' => $tipoTributacoes, 'naturezasJuridicas' => $naturezasJuridicas]);
    }

    public function store(Request $request) {
        $empresa = new \App\Pessoa;
        $request->merge(['id_usuario' => Auth::user()->id]);
        if (count($request->get('cnaes'))) {
            foreach ($request->get('cnaes') as $cnae) {
                if (\App\Cnae::where('id', '=', $cnae)->first()->id_tabela_simples_nacional == null) {
                    return redirect(route('cadastrar-empresa'))->withInput()->withErrors(['Não foi possível cadastrar sua empresa pois um de seus CNAEs não está apto para o Simples Nacional.\nNesse momento só trabalhamos com Simples Nacional.']);
                }
            }
        }

        //atencao, arrumar telefone!!!!!!!!!!!!!!!!!!!!
        $request->merge([
            'id_tipo_tributacao' => 1,
            'telefone' => '123456',
            'qtde_funcionarios' => 0,
            'id_uf'=>24
        ]);
        if ($empresa->validate($request->except('_token'))) {


            $empresa = $empresa->create($request->except('_token', 'cnaes', 'socio'));
            if (count($request->get('socio'))) {
                $socio = new \App\Socio;
                
                $socioData = $request->get('socio');
                $socioData['id_pessoa'] = $empresa->id;
                if ($request->get('socio')['pro_labore']) {
                    $socioData['pro_labore'] = str_replace(',','.',preg_replace('#[^\d\,]#is','',$request->get('socio')['pro_labore']));
                }
                $request->merge([
                    'socio' => $socioData
                ]);
                $socio = $socio->create($request->get('socio'));
            }
            if (count($request->get('cnaes'))) {
                foreach ($request->get('cnaes') as $cnae) {
                    $pessoaCnae = new \App\PessoaCnae;
                    $pessoaCnae->id_pessoa = $empresa->id;
                    $pessoaCnae->id_cnae = $cnae;
                    $pessoaCnae->save();
                }
            }
            return redirect(route('empresas'));
        } else {
            return redirect(route('cadastrar-empresa'))->withInput()->withErrors($empresa->errors());
        }
    }

    public function edit($id) {
        $empresa = \App\Pessoa::where('id', '=', $id)->where('id_usuario', '=', Auth::user()->id)->first();
        $tipoTributacoes = \App\TipoTributacao::orderBy('descricao', 'asc')->get();
        $naturezasJuridicas = \App\NaturezaJuridica::orderBy('descricao', 'asc')->get();
        return view('empresa.editar', [ 'tipoTributacoes' => $tipoTributacoes, 'naturezasJuridicas' => $naturezasJuridicas, 'empresa' => $empresa]);
    }

    public function update($id, Request $request) {

        $empresa = \App\Pessoa::where('id', '=', $id)->where('id_usuario', '=', Auth::user()->id)->first();
        $request->merge(['id' => $empresa->id]);
        if (count($request->get('cnaes'))) {
            foreach ($request->get('cnaes') as $cnae) {
                if (\App\Cnae::where('id', '=', $cnae)->first()->id_tabela_simples_nacional == null) {
                    return redirect(route('editar-empresa', $id))->withInput()->withErrors(['Não foi possível cadastrar sua empresa pois um de seus CNAEs não está apto para o Simples Nacional.\nNesse momento só trabalhamos com Simples Nacional.']);
                }
            }
        }

        if ($empresa->validate($request->except('_token'), true)) {

            $empresa->update($request->except('_token', 'cnaes', 'socio'));
            if (count($request->get('cnaes'))) {
                foreach ($empresa->cnaes()->get() as $cnae) {
                    $cnae->delete();
                }
                foreach ($request->get('cnaes') as $cnae) {
                    $pessoaCnae = new \App\PessoaCnae;
                    $pessoaCnae->id_pessoa = $id;
                    $pessoaCnae->id_cnae = $cnae;
                    $pessoaCnae->save();
                }
            }
            return redirect(route('empresas'));
        } else {
            return redirect(route('editar-empresa', [$id]))->withInput()->withErrors($empresa->errors());
        }
    }

    public function register() {
        return view('register.index');
    }

    public function checkEmail(Request $request) {
        $usuario = \App\Usuario::where('email', '=', $request->input('email'))->first();
        if ($usuario instanceof \App\Usuario) {
            return redirect(route('login'))->with('email', $request->input('email'));
        } else {
            return redirect(route('registrar'));
        }
    }

}
