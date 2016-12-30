<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Mensalidade extends Model {

    use SoftDeletes;

    protected $rules = ['id_usuario' => 'required', 'id_pessoa' => 'required', 'duracao' => 'required', 'valor' => 'required|numeric', 'tipo' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mensalidade';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario', 'id_pessoa', 'valor', 'duracao', 'documentos_fiscais', 'documentos_contabeis', 'pro_labores', 'funcionarios', 'status', 'created_at'];

    public function validate($data) {
        // make a new validator object
        $v = Validator::make($data, $this->rules);
        $v->setAttributeNames($this->niceNames);
        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors()->all();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors() {
        return $this->errors;
    }

    public function ultimo_pagamento($formato = 'Y-m-d') {
        $ultimo_pagamento = Pagamento::where('id_mensalidade','=',$this->id)->where('status', '=', 'Paga')->orderBy('created_at', 'desc')->first();
        if ($ultimo_pagamento instanceof Pagamento) {
            return $ultimo_pagamento->updated_at->format($formato);
        }
        return false;
    }

    public function proximo_pagamento($formato = 'Y-m-d') {
        try {
            $data_vencimento = $this->created_at->format('d');
            $ultimo_pagamento = date_format($this->pagamentos()->where('tipo', '=', 'mensalidade')->orderBy('created_at', 'desc')->first()->created_at, 'Y-m');
            $date = strtotime("+1 month", strtotime($ultimo_pagamento . '-' . $data_vencimento));
            $vencimento = date($formato, strtotime("+5 days", $date));
            return $vencimento;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function abrir_ordem_pagamento() {
        try {
            $data_vencimento = $this->created_at->format('d');
            $ultimo_pagamento = date_format($this->pagamentos()->where('tipo', '=', 'mensalidade')->orderBy('created_at', 'desc')->first()->created_at, 'Y-m');
            $date = strtotime("+1 month", strtotime($ultimo_pagamento . '-' . $data_vencimento));
            $vencimento = date('Y-m-d', strtotime("+5 days", $date));
            if (date('Ymd') == date('Ymd', $date)) {

                if ($this->empresa->status == 'Aprovado' && !$this->empresa->trashed()) {
                    $pagamento = new \App\Pagamento;
                    $pagamento->id_mensalidade = $this->id;
                    $pagamento->status = 'Pendente';
                    $pagamento->valor = $this->valor;
                    $pagamento->vencimento = $vencimento;
                    $pagamento->save();
                    $this->enviar_notificacao_cobranca();
                }
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function enviar_notificacao_cobranca() {
        $usuario = Auth::user();
        $notificacao = new Notificacao;
        $valor = number_format($this->valor, 2, ',', '.');
        $notificacao->mensagem = '<a href="' . route('listar-pagamentos-pendentes') . '">Você possui uma nova cobrança de R$' . $valor . '. Clique aqui para visualizar seus pagamentos pendentes.</a>';
        $notificacao->id_usuario = Auth::user()->id;
        $notificacao->save();
        try {
            \Illuminate\Support\Facades\Mail::send('emails.nova-cobranca', ['nome' => $usuario->nome, 'empresa' => $this->empresa->nome_fantasia, 'valor' => $valor], function ($m) use($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Você possui uma nova cobrança.');
            });
            \Illuminate\Support\Facades\Mail::send('emails.nova-cobranca-admin', ['nome' => $this->empresa->nome_fantasia, 'valor' => $valor], function ($m) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Uma nova cobrança foi gerada.');
            });
        } catch (\Exception $ex) {
            var_dump($ex);
            return true;
        }
    }

    public function valor_formatado() {
        $format = new \NumberFormatter("pt-BR", \NumberFormatter::CURRENCY);
        return $format->format($this->valor);
    }

    public function pagamentos() {
        return $this->hasMany('App\Pagamento', 'id_mensalidade');
    }

    public function empresa() {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

}
