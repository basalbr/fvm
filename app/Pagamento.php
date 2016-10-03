<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;

class Pagamento extends Model {

    use SoftDeletes;

    protected $rules = ['id_mensalidade' => 'required', 'status' => 'required', 'vencimento' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pagamento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_mensalidade', 'status', 'vencimento'];

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

    public function mensalidade() {
        return $this->belongsTo('App\Mensalidade', 'id_mensalidade');
    }

    public function historico_pagamentos() {
        return $this->hasMany('App\Pagamento', 'id_mensalidade');
    }

    public function botao_pagamento() {
        if ($this->status == 'Devolvida' || $this->status == 'Cancelada' || $this->status == 'Pendente' || $this->status == 'Aguardando pagamento') {
            $data = [
                'items' => [
                    [
                        'id' => $this->mensalidade->id,
                        'description' => 'Mensalidade WebContabilidade',
                        'quantity' => '1',
                        'amount' => $this->mensalidade->valor,
                    ],
                ],
                'notificationURL' => 'http://www.webcontabilidade.com/pagseguro',
                'reference' => $this->id,
                'sender' => [
                    'email' => 'c88672221307210906171@sandbox.pagseguro.com.br',
                    'name' => 'Aldir Junior',
                    'documents' => [
                        [
                            'number' => '06873589900',
                            'type' => 'CPF'
                        ]
                    ],
                    'phone' => '(47)9617-2512',
                    'bornDate' => '1989-03-10',
                ]
            ];
            $checkout = Pagseguro::checkout()->createFromArray($data);
            $credentials = PagSeguro::credentials()->get();
            $information = $checkout->send($credentials); // Retorna um objeto de laravel\pagseguro\Checkout\Information\Information
            return '<a href="'.$information->getLink().'" class="btn btn-success">Clique para pagar</a>';
        }
        if ($this->status == 'Disponível' || $this->status == 'Em análise') {
            return '<a href="" class="btn btn-success" disabled>Em processamento</a>';
        }
        return null;
    }

}
