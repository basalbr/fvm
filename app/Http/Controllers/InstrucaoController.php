<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imposto;
use App\Instrucao;
use Illuminate\Http\Request;

class InstrucaoController extends Controller {

    public function index($id_imposto) {
        $imposto = Imposto::findOrFail($id_imposto);
        return view('admin.imposto.instrucoes.index', ['imposto' => $imposto]);
    }

    public function create($id_imposto) {
        $instr = Instrucao::where('id_imposto', '=', $id_imposto)->orderBy('ordem', 'desc')->first(['ordem']);
        $ordem = $instr instanceof Instrucao ? $instr->ordem : 0; 
        
        return view('admin.imposto.instrucoes.cadastrar', ['id_imposto' => $id_imposto, 'ordem'=>$ordem]);
    }

    public function store($id_imposto, Request $request) {
        $instrucao = new Instrucao;
        $dados = $request->only('ordem', 'descricao');
        if ($instrucao->validate($dados)) {
            $dados['id_imposto'] = (int)$id_imposto;
            $instrucao = $instrucao->create($dados);
            return redirect(route('listar-instrucao', ['id_imposto'=>$id_imposto]));
        } else {
            return redirect(route('cadastrar-instrucao', ['id_imposto'=>$id_imposto]))->withInput()->withErrors($instrucao->errors());
        }
    }

    public function edit($id_imposto, $id_instrucao) {
        $instr = Instrucao::where('id', '=', $id_instrucao)->first();
        return view('admin.imposto.instrucoes.editar', ['instrucao' => $instr]);
    }

    public function update($id_imposto, $id_instrucao, Request $request) {
        $instrucao = Instrucao::where('id', '=', $id_instrucao)->first();
        $dados = $request->only('ordem', 'descricao');
        if ($instrucao->validate($dados)) {
            $instrucao = $instrucao->update($dados);
            return redirect(route('listar-instrucao', ['id_imposto'=>$id_imposto]));
        } else {
            return redirect(route('editar-instrucao', ['id_imposto'=>$id_imposto, 'id_instrucao'=>$id_instrucao]))->withInput()->withErrors($instrucao->errors());
        }
    }

    public function ajaxCalendar() {
        $impostos = Instrucao::all();
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
