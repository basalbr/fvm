<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Socio;
use App\Prolabore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ProlaboreController extends Controller {

    public function index() {
        $socios = Socio::where('pro_labore', '>', 0)->orderBy('id_pessoa')->paginate(10);
        return view('admin.pro_labore.index', ['socios' => $socios]);
    }

    public function indexCliente() {
        $pro_labores = Prolabore::query();
        $pro_labores->join('socio', 'socio.id', '=', 'pro_labore.id_socio')->join('pessoa', 'pessoa.id', '=', 'socio.id_pessoa')->where('pessoa.id_usuario', '=', Auth::user()->id);

        if (Input::get('competencia_de')) {
            $data = explode('/', Input::get('de'));
            $data = $data[2] . '-' . $data[1] . '-' . '01';
            $pro_labores->where('pro_labore.competencia', '>=', $data);
        }
        if (Input::get('competencia_ate')) {
            $data = explode('/', Input::get('ate'));
            $data = $data[2] . '-' . $data[1] . '-' . '01';
            $pro_labores->where('pro_labore.competencia', '<=', $data);
        }

        if (Input::get('empresa')) {
            $pro_labores->where('pessoa.id', '=', Input::get('empresa'));
        }
        if (Input::get('socio')) {
            $pro_labores->where('pro_labore.id_socio', '=', Input::get('socio'));
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'empresa') {
                $pro_labores->orderBy('pessoa.nome_fantasia');
            }
            if (Input::get('ordenar') == 'socio') {
                $pro_labores->orderBy('socio.nome');
            }
            if (Input::get('ordenar') == 'competencia') {
                $pro_labores->orderBy('competencia', 'desc');
            }
        } else {
            $pro_labores->orderBy('competencia', 'desc');
        }

        $pro_labores = $pro_labores->select('pro_labore.*')->paginate(10);

        return view('pro_labore.index', ['pro_labores' => $pro_labores]);
    }

    public function socio($id) {
        $socio = Socio::where('id', '=', $id)->first();
        return view('pro_labore.index-socio', ['socio' => $socio]);
    }

    public function historico() {
        $pro_labores = Prolabore::orderBy('updated_at', 'desc')->get();
        return view('admin.pro_labore.historico', ['pro_labores' => $pro_labores]);
    }

    public function create($id) {
        $socio = Socio::where('id', '=', $id)->first();
        return view('admin.pro_labore.cadastrar', ['socio' => $socio]);
    }

    public function store($id, Request $request) {
        $pro_labore = new Prolabore;
        if ($pro_labore->validate($request->all())) {

            $pro_labore_anexo = $request->file('pro_labore');
            $pro_labore_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $pro_labore_anexo->guessClientExtension();
            $pro_labore_anexo->move(getcwd() . '/uploads/pro_labore/', $pro_labore_nome);

            $inss_anexo = $request->file('inss');
            $inss_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $inss_anexo->guessClientExtension();
            $inss_anexo->move(getcwd() . '/uploads/inss/', $inss_nome);

            $irrf_nome = '';

            if ($request->file('irrf')) {
                $irrf_anexo = $request->file('irrf');
                $irrf_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $irrf_anexo->guessClientExtension();
                $irrf_anexo->move(getcwd() . '/uploads/irrf/', $irrf_nome);
                $request->merge(['irrf' => $irrf_nome]);
            }
            $pro_labore->create(['competencia' => date('Y-m-d'), 'valor_pro_labore' => $request->get('valor_pro_labore'), 'id_socio' => $id, 'irrf' => $irrf_nome, 'inss' => $inss_nome, 'pro_labore' => $pro_labore_nome]);
            return redirect(route('listar-pro-labore'));
        } else {
            return redirect(route('cadastrar-pro-labore', [$id]))->withInput()->withErrors($pro_labore->errors());
        }
    }

    public function edit($id, $id_pro_labore) {
        $pro_labore = Prolabore::where('id', '=', $id_pro_labore)->first();
        return view('admin.pro_labore.editar', ['pro_labore' => $pro_labore]);
    }

    public function socioEdit($id, $id_pro_labore) {
        $pro_labore = Prolabore::where('id', '=', $id_pro_labore)->where('id_socio', '=', $id)->first();
        return view('pro_labore.visualizar', ['pro_labore' => $pro_labore]);
    }

    public function update($id, $id_pro_labore, Request $request) {
        $pro_labore = Prolabore::where('id_socio', '=', $id)->where('id', '=', $id_pro_labore)->first();
        if ($request->file('pro_labore')) {
            $pro_labore_anexo = $request->file('pro_labore');
            $pro_labore_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $pro_labore_anexo->guessClientExtension();
            $pro_labore_anexo->move(getcwd() . '/uploads/pro_labore/', $pro_labore_nome);
            $pro_labore->pro_labore = $pro_labore_nome;
        }

        if ($request->file('inss')) {
            $inss_anexo = $request->file('inss');
            $inss_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $inss_anexo->guessClientExtension();
            $inss_anexo->move(getcwd() . '/uploads/inss/', $inss_nome);
            $pro_labore->inss = inss;
        }

        if ($request->file('irrf')) {
            $irrf_anexo = $request->file('irrf');
            $irrf_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $irrf_anexo->guessClientExtension();
            $irrf_anexo->move(getcwd() . '/uploads/irrf/', $irrf_nome);
            $pro_labore->irrf = irrf;
        }
        $pro_labore->save();
        return redirect(route('listar-pro-labore-historico'));
    }

}
