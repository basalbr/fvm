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
        $request->merge(['id_imposto'=>$id_imposto]);
        if ($informacao_extra->validate($request->all())) {
            $informacao_extra = $informacao_extra->create($request->all());
            if($request->get('tipo')=='anexo'){
                foreach($request->get('extensao') as $extensao){
                    $ext = new \App\InformacaoExtraExtensao;
                    $ext->id_informacao_extra = $informacao_extra->id;
                    $ext->extensao = $extensao;
                    $ext->save();
                }
            }
            return redirect(route('listar-informacao-extra', ['id_imposto'=>$id_imposto]));
        } else {
            return redirect(route('cadastrar-informacao-extra', ['id_imposto'=>$id_imposto]))->withInput()->withErrors($informacao_extra->errors());
        }
    }

    public function edit($id_imposto, $id_informacao_extra) {
        $instr = InformacaoExtra::where('id', '=', $id_informacao_extra)->where('id_imposto','=',$id_imposto)->first();
        return view('admin.imposto.informacoes_extras.editar', ['informacao_extra' => $instr]);
    }

    public function update($id_imposto, $id_informacao_extra, Request $request) {
        $informacao_extra = InformacaoExtra::where('id', '=', $id_informacao_extra)->first();
        $request->merge(['id_imposto'=>$id_imposto]);
        if ($informacao_extra->validate($request->all())) {
            $informacao_extra->update($request->all());
            if($request->get('tipo')=='anexo'){
                foreach($informacao_extra->extensoes as $extensao){
                    $extensao->delete();
                }
                foreach($request->get('extensao') as $extensao){
                    $ext = new \App\InformacaoExtraExtensao;
                    $ext->id_informacao_extra = $informacao_extra->id;
                    $ext->extensao = $extensao;
                    $ext->save();
                }
            }
            return redirect(route('listar-informacao-extra', ['id_imposto'=>$id_imposto]));
        } else {
            return redirect(route('editar-informacao-extra', ['id_imposto'=>$id_imposto, 'id_informacao_extra'=>$id_informacao_extra]))->withInput()->withErrors($informacao_extra->errors());
        }
    }
   

}
