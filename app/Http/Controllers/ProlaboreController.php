<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Socio;
use App\Prolabore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ProlaboreController extends Controller
{

    public function index()
    {
        $socios = Socio::query();
        $socios->join('pessoa', 'pessoa.id', '=', 'socio.id_pessoa');
        $socios->where('socio.pro_labore', '>', 0);
        $socios->where('pessoa.deleted_at', '=', null);
        if (Input::get('socio')) {
            $socios->where('socio.nome', 'like', '%' . Input::get('socio') . '%');
        }
        if (Input::get('empresa')) {
            $socios->where('pessoa.nome_fantasia', 'like', '%' . Input::get('empresa') . '%');
            $socios->where('pessoa.razao_social', 'like', '%' . Input::get('empresa') . '%');
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'empresa_asc') {
                $socios->orderBy('pessoa.nome_fantasia', 'asc');
            }
            if (Input::get('ordenar') == 'empresa_desc') {
                $socios->orderBy('pessoa.nome_fantasia', 'desc');
            }
            if (Input::get('ordenar') == 'socio_asc') {
                $socios->orderBy('socio.nome', 'asc');
            }
            if (Input::get('ordenar') == 'socio_desc') {
                $socios->orderBy('socio.nome', 'desc');
            }
        } else {
            $socios->orderBy('pessoa.nome_fantasia', 'asc');
        }
        $socios = $socios->select('socio.*')->paginate(20);
        return view('admin.pro_labore.index', ['socios' => $socios]);
    }

    public function indexCliente()
    {
        $pro_labores = Prolabore::query();
        $pro_labores->join('socio', 'socio.id', '=', 'pro_labore.id_socio')->join('pessoa', 'pessoa.id', '=', 'socio.id_pessoa')->where('pessoa.id_usuario', '=', Auth::user()->id)->where('pessoa.deleted_at', '=', null);
        if (Input::get('socio')) {
            $pro_labores->where('socio.id', '=', Input::get('socio'));
        }
        if (Input::get('empresa')) {
            $pro_labores->where('pessoa.id', '=', Input::get('empresa'));
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'created_at_asc') {
                $pro_labores->orderBy('pro_labore.created_at', 'asc');
            }
            if (Input::get('ordenar') == 'created_at_desc') {
                $pro_labores->orderBy('pro_labore.created_at', 'desc');
            }
            if (Input::get('ordenar') == 'empresa_asc') {
                $pro_labores->orderBy('pessoa.nome_fantasia', 'asc');
            }
            if (Input::get('ordenar') == 'empresa_desc') {
                $pro_labores->orderBy('pessoa.nome_fantasia', 'desc');
            }
            if (Input::get('ordenar') == 'socio_asc') {
                $pro_labores->orderBy('socio.nome', 'asc');
            }
            if (Input::get('ordenar') == 'socio_desc') {
                $pro_labores->orderBy('socio.nome', 'desc');
            }
        } else {
            $pro_labores->orderBy('pessoa.nome_fantasia', 'asc');
        }

        $pro_labores = $pro_labores->select('pro_labore.*')->paginate(10);

        return view('pro_labore.index', ['pro_labores' => $pro_labores]);
    }

    public function socio($id)
    {
        $socio = Socio::where('id', '=', $id)->first();
        return view('pro_labore.index-socio', ['socio' => $socio]);
    }

    public function historico()
    {
        $pro_labores = Prolabore::orderBy('updated_at', 'desc')->get();
        return view('admin.pro_labore.historico', ['pro_labores' => $pro_labores]);
    }

    public function create($id)
    {
        $socio = Socio::where('id', '=', $id)->first();
        return view('admin.pro_labore.cadastrar', ['socio' => $socio]);
    }

    public function store($id, Request $request)
    {
        $pro_labore = new Prolabore;
        if ($pro_labore->validate($request->all())) {

            $pro_labore_anexo = $request->file('pro_labore');
            $pro_labore_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $pro_labore_anexo->getClientOriginalExtension();
            $pro_labore_anexo->move(getcwd() . '/uploads/pro_labore/', $pro_labore_nome);

            $inss_anexo = $request->file('inss');
            $inss_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $inss_anexo->getClientOriginalExtension();
            $inss_anexo->move(getcwd() . '/uploads/inss/', $inss_nome);

            $irrf_nome = '';

            if ($request->file('irrf')) {
                $irrf_anexo = $request->file('irrf');
                $irrf_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $irrf_anexo->getClientOriginalExtension();
                $irrf_anexo->move(getcwd() . '/uploads/irrf/', $irrf_nome);
                $request->merge(['irrf' => $irrf_nome]);
            }
            $pro_labore->create(['competencia' => date('Y-m-d', strtotime(date('Y-m') . " -1 month")), 'valor_pro_labore' => $request->get('valor_pro_labore'), 'id_socio' => $id, 'irrf' => $irrf_nome, 'inss' => $inss_nome, 'pro_labore' => $pro_labore_nome]);
            return redirect(route('listar-pro-labore'));
        } else {
            return redirect(route('cadastrar-pro-labore', [$id]))->withInput()->withErrors($pro_labore->errors());
        }
    }

    public function edit($id, $id_pro_labore)
    {
        $pro_labore = Prolabore::where('id', '=', $id_pro_labore)->first();
        return view('admin.pro_labore.editar', ['pro_labore' => $pro_labore]);
    }

    public function socioEdit($id, $id_pro_labore)
    {
        $pro_labore = Prolabore::where('id', '=', $id_pro_labore)->where('id_socio', '=', $id)->first();
        return view('pro_labore.visualizar', ['pro_labore' => $pro_labore]);
    }

    public function update($id, $id_pro_labore, Request $request)
    {
        $pro_labore = Prolabore::where('id_socio', '=', $id)->where('id', '=', $id_pro_labore)->first();
        if ($request->file('pro_labore')) {
            $pro_labore_anexo = $request->file('pro_labore');
            $pro_labore_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $pro_labore_anexo->getClientOriginalExtension();
            $pro_labore_anexo->move(getcwd() . '/uploads/pro_labore/', $pro_labore_nome);
            $pro_labore->pro_labore = $pro_labore_nome;
        }

        if ($request->file('inss')) {
            $inss_anexo = $request->file('inss');
            $inss_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $inss_anexo->getClientOriginalExtension();
            $inss_anexo->move(getcwd() . '/uploads/inss/', $inss_nome);
            $pro_labore->inss = inss;
        }

        if ($request->file('irrf')) {
            $irrf_anexo = $request->file('irrf');
            $irrf_nome = 'pro_labore' . str_shuffle(date('dmyhis')) . '.' . $irrf_anexo->getClientOriginalExtension();
            $irrf_anexo->move(getcwd() . '/uploads/irrf/', $irrf_nome);
            $pro_labore->irrf = irrf;
        }
        $pro_labore->save();
        return redirect(route('listar-pro-labore-historico'));
    }

}
