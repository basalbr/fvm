<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Pagamento;
use Illuminate\Http\Request;
use App\HistoricoPagamento;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller {

    public function index() {
        $pagamentos = Pagamento::join('mensalidade','mensalidade.id','=','pagamento.id_mensalidade')->where('mensalidade.id_usuario','=', Auth::user()->id)->where('pagamento.status','!=','Paga')->where('pagamento.status','!=','Concluída')->orderBy('pagamento.created_at', 'desc')->select('pagamento.*')->paginate(5);
        return view('pagamentos.index', ['pagamentos' => $pagamentos]);
    }

    public function historico() {
         $pagamentos = Pagamento::join('mensalidade','mensalidade.id','=','pagamento.id_mensalidade')->where('mensalidade.id_usuario','=', Auth::user()->id)->where('pagamento.status','=','Paga')->orWhere('pagamento.status','=','Concluída')->orderBy('pagamento.created_at', 'desc')->select('pagamento.*')->paginate(5);
        return view('pagamentos.historico', ['pagamentos' => $pagamentos]);
    }

    public function store(Request $request) {
        $pagamento = new Pagamento;
        $request->merge(['valor' => str_replace(',', '.', preg_replace('#[^\d\,]#is', '', $request->get('valor')))]);
        if ($pagamento->validate($request->all())) {
            $pagamento->create($request->all());
            return redirect(route('listar-pagamento'));
        } else {
            return redirect(route('cadastrar-pagamento'))->withInput()->withErrors($pagamento->errors());
        }
    }

    public function edit($id) {
        $pagamento = Pagamento::where('id', '=', $id)->first();
        return view('admin.pagamento.editar', ['pagamento' => $pagamento]);
    }

    public function update($id, Request $request) {
        $pagamento = Pagamento::where('id', '=', $id)->first();
        $request->merge(['valor' => str_replace(',', '.', preg_replace('#[^\d\,]#is', '', $request->get('valor')))]);
        if ($pagamento->validate($request->all())) {
            $pagamento->update($request->all());
            return redirect(route('listar-pagamento'));
        } else {
            return redirect(route('editar-pagamento'))->withInput()->withErrors($pagamento->errors());
        }
    }

   public static function notification($info){
       $historico_pagamento = HistoricoPagamento::where('transaction_id','=',$info->getCode())->where('id_pagamento','=',$info->getReference())->first();
       if($historico_pagamento instanceof HistoricoPagamento){
           if($historico_pagamento->status != 'Aprovado' && $info->getStatus()->getName() != 'Concluído'){
               $historico_pagamento->status = $info->getStatus()->getName();
               $historico_pagamento->save();
           }
       }else{
           $historico_pagamento = new HistoricoPagamento;
           $historico_pagamento->id_pagamento = $info->getReference();
           $historico_pagamento->transaction_id = $info->getCode();
           $historico_pagamento->status = $info->getStatus()->getName();
           $historico_pagamento->save();
       }
       $pagamento = Pagamento::find($info->getReference());
       $pagamento->status = $info->getStatus()->getName();
       $pagamento->save();
   }

}