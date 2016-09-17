<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imposto;
use App\ImpostoMes;
use Illuminate\Http\Request;

class ImpostoController extends Controller {

    private static $arr_meses = array(
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    );

    
    
    private function corrigeData($date, $option) {
        $retDate = new \DateTime($date);
        $weekDay = date('w', strtotime($date));
        if ($option == 'posterga') {
            if ($weekDay == 0) {
                $retDate->add(new \DateInterval('P1D'));
            }
            if ($weekDay == 6) {
                $retDate->add(new \DateInterval('P2D'));
            }
        }
        if ($option == 'antecipa') {
            if ($weekDay == 0) {
                $retDate->sub(new \DateInterval('P2D'));
            }
            if ($weekDay == 6) {
                $retDate->sub(new \DateInterval('P1D'));
            }
        }
        return $retDate->format('Y-m-d');
    }

    public function index() {
        $impostos = Imposto::orderBy('nome', 'asc')->get();
        return view('admin.imposto.index', ['impostos' => $impostos]);
    }

    public function create() {

        return view('admin.imposto.cadastrar', ['meses' => $this::$arr_meses]);
    }

    public function store(Request $request) {
        $tbn = new Imposto;
        if ($tbn->validate($request->only(['nome', 'vencimento', 'antecipa_posterga', 'recebe_documento']))) {
            $tbn = $tbn->create($request->only('nome', 'vencimento', 'antecipa_posterga', 'recebe_documento'));
            if ($request->has('meses')) {
                foreach ($request->get('meses') as $mes) {
                    $impostoMes = new ImpostoMes;
                    $impostoMes->id_imposto = $tbn->id;
                    $impostoMes->mes = $mes;
                    $impostoMes->save();
                }
            }
            return redirect(route('listar-imposto'));
        } else {
            return redirect(route('cadastrar-imposto'))->withInput()->withErrors($tbn->errors());
        }
    }

    public function edit($id) {
        $imposto = Imposto::where('id', '=', $id)->first();
        return view('admin.imposto.editar', ['imposto' => $imposto, 'meses' => $this::$arr_meses]);
    }

    public function update($id, Request $request) {
        $tbn = Imposto::where('id', '=', $id)->first();
        if ($tbn->validate($request->only(['nome', 'vencimento', 'antecipa_posterga', 'recebe_documento']))) {
            $tbn->update($request->only(['nome', 'vencimento', 'antecipa_posterga', 'recebe_documento']));
            if (count($tbn->meses)) {
                foreach ($tbn->meses as $impostoMes) {
                    $impostoMes->delete();
                }
            }
            if ($request->has('meses')) {
                foreach ($request->get('meses') as $mes) {
                    $impostoMes = new ImpostoMes;
                    $impostoMes->id_imposto = $tbn->id;
                    $impostoMes->mes = $mes;
                    $impostoMes->save();
                }
            }
            return redirect(route('listar-imposto'));
        } else {
            return redirect(route('editar-imposto'))->withInput()->withErrors($tbn->errors());
        }
    }

    public function ajaxCalendar() {
        $impostos = Imposto::all();
        $jsonRet = array();
        if ($impostos->count()) {
            foreach ($impostos as $imposto) {
                if ($imposto->meses->count()) {
                    foreach ($imposto->meses as $impostoMes) {
                        $mes = $impostoMes->mes + 1;
                        $date = $this->corrigeData(date('Y') . '-' . $mes . '-' . $imposto->vencimento, $imposto->antecipa_posterga);
                        $jsonRet[] = array('title' => $imposto->nome, 'start' => $date, 'id' => $imposto->id);
                    }
                }
            }
        }
        return response()->json($jsonRet);
    }
    
    public function ajaxInstrucoes( Request $request){
        
        $instrucoes = Imposto::find($request->get('id'))->instrucoes()->orderBy('ordem', 'asc')->get(['descricao']);
        return response()->json($instrucoes);
    }

}
