<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;

class Alteracao extends Model
{

    use SoftDeletes;

    protected $rules = ['id_pessoa' => 'required', 'id_tipo_alteracao' => 'required'];
    protected $errors;
    protected $niceNames = ['id_pessoa' => 'Empresa', 'id_tipo_alteracao' => 'Tipo de Alteração'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_pessoa', 'descricao', 'status', 'id_tipo_alteracao'];

    public function validate($data, $rules, $niceNames)
    {
        // make a new validator object
        $v = Validator::make($data, $rules);
        $v->setAttributeNames($niceNames);
        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors()->all();
            return false;
        }

        // validation pass
        return true;
    }

    public function validateMeiMe($data)
    {
        $rules = ['id_pessoa' => 'required', 'titulo_eleitor' => 'required', 'recibo_ir' => 'sometimes'];
        $niceNames = ['id_pessoa' => 'Empresa', 'titulo_eleitor' => 'Título de Eleitor', 'recibo_ir' => 'Número do Recibo do Último Imposto de Renda'];
        return $this->validate($data, $rules, $niceNames);
    }

    public function enviar_notificacao_nova_alteracao()
    {
        $usuario = $this->empresa->usuario;
        try {
            \Illuminate\Support\Facades\Mail::send('emails.nova-alteracao', ['nome' => $usuario->nome, 'id_alteracao' => $this->id, 'id_empresa' => $this->id_empresa, 'tipo_alteracao' => $this->tipo->descricao], function ($m) use ($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Nova Solicitação de  Alteração');
            });
            \Illuminate\Support\Facades\Mail::send('emails.nova-alteracao-admin', ['nome' => $usuario->nome, 'id_alteracao' => $this->id, 'tipo_alteracao' => $this->tipo->descricao], function ($m) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Nova Solicitação de Alteração');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function abrir_ordem_pagamento()
    {
        $pagamento = new \App\Pagamento;
        $pagamento->tipo = 'alteracao';
        $pagamento->codigo = $this->id;
        $pagamento->valor = $this->tipo->valor;
        $pagamento->status = 'Pendente';
        $pagamento->vencimento = date('Y-m-d H:i:s', strtotime("+7 day"));
        $pagamento->save();
    }

    public function botao_pagamento()
    {
        if (
            ($this->status == 'Pendente' ||
                $this->status == 'Em Processamento' ||
                $this->status == 'Novo') &&
            ($this->pagamento->status == 'Devolvida' ||
                $this->pagamento->status == 'Cancelada' ||
                $this->pagamento->status == 'Pendente' ||
                $this->pagamento->status == 'Aguardando pagamento')
        ) {

            $name = Auth::user()->nome;
            if (!strpos(trim($name), ' ')) {
                $name = $name . ' ' . $name;

            }
            $data = [
                'items' => [
                    [
                        'id' => $this->id,
                        'description' => $this->tipo->descricao,
                        'quantity' => '1',
                        'amount' => $this->pagamento->valor,
                    ],
                ],
                'notificationURL' => 'http://www.webcontabilidade.com/pagseguro',
                'reference' => $this->id,
                'sender' => [

                    'name' => $name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->telefone
                ]
            ];
            $checkout = Pagseguro::checkout()->createFromArray($data);
            $credentials = PagSeguro::credentials()->get();
            $information = $checkout->send($credentials); // Retorna um objeto de laravel\pagseguro\Checkout\Information\Information
            return '<a href="' . $information->getLink() . '" class="btn btn-success"><span class="fa fa-credit-card"></span> Clique para pagar</a>';
        }
        if ($this->status == 'Disponível' || $this->status == 'Em análise') {
            return '<a href="" class="btn btn-success" disabled>Em processamento</a>';
        }
        return null;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function empresa()
    {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

    public function tipo()
    {
        return $this->belongsTo('App\TipoAlteracao', 'id_tipo_alteracao');
    }

    public function informacoes()
    {
        return $this->hasMany('App\AlteracaoInformacao', 'id_alteracao');
    }

    public function mensagens()
    {
        return $this->hasMany('App\AlteracaoMensagem', 'id_alteracao');
    }

    public function pagamento()
    {
        return $this->hasOne('App\Pagamento', 'codigo')->where('tipo', '=', 'alteracao');
    }

}
