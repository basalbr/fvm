<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imposto;
use App\InformacaoExtra;
use Illuminate\Http\Request;

class InformacaoExtraController extends Controller {

    public function index($id_imposto) {
        $imposto = Imposto::findOrFail($id_imposto);
        return view('admin.imposto.informacoes_extras.index', ['imposto' => $imposto]);
    }

    public function create($id_imposto) {
        return view('admin.imposto.informacoes_extras.cadastrar', ['id_imposto' => $id_imposto]);
    }

    public function store($id_imposto, Request $request) {
        $informacao_extra = new InformacaoExtra;
        $dados = $request->only('ordem', 'descricao');
        if ($informacao_extra->validate($dados)) {
            $dados['id_imposto'] = (int)$id_imposto;
            $informacao_extra = $informacao_extra->create($dados);
            return redirect(route('listar-informacao_extra', ['id_imposto'=>$id_imposto]));
        } else {
            return redirect(route('cadastrar-informacao_extra', ['id_imposto'=>$id_imposto]))->withInput()->withErrors($informacao_extra->errors());
        }
    }

    public function edit($id_imposto, $id_informacao_extra) {
        $instr = InformacaoExtra::where('id', '=', $id_informacao_extra)->andWhere('id_imposto','=',$id_imposto)->first();
        return view('admin.imposto.informacoes_extras.editar', ['informacao_extra' => $instr]);
    }

    public function update($id_imposto, $id_informacao_extra, Request $request) {
        $informacao_extra = InformacaoExtra::where('id', '=', $id_informacao_extra)->first();
        $dados = $request->only('ordem', 'descricao');
        if ($informacao_extra->validate($dados)) {
            $informacao_extra = $informacao_extra->update($dados);
            return redirect(route('listar-informacao_extra', ['id_imposto'=>$id_imposto]));
        } else {
            return redirect(route('editar-informacao_extra', ['id_imposto'=>$id_imposto, 'id_informacao_extra'=>$id_informacao_extra]))->withInput()->withErrors($informacao_extra->errors());
        }
    }

    public function ajaxCalendar() {
        $impostos = InformacaoExtra::all();
        $jsonRet = array();
        if ($impostos->count()) {
            foreach ($impostos as $imposto) {
                if ($imposto->meses->count()) {
                    foreach ($imposto->meses as $impostoMes) {
                        $mes = $impostoMes->mes + 1;
                        $date = $this->corrigeData(date('Y') . '-' . $mes . '-' . $imposto->vencimento, $imposto->antecipa_posterga);
                        $jsonRet[] = array('title' => $imposto->nome, 'start' => $date);
                    }
                }
            }
        }
        return response()->json($jsonRet);
    }

}
