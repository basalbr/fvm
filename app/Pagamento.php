<?php

namespace App;

use Aws\S3\Exception\RequestTimeoutException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;
use Psy\Exception\FatalErrorException;

class Pagamento extends Model
{

    use SoftDeletes;

    protected $rules = ['id_mensalidade' => 'required', 'status' => 'required', 'vencimento' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'];
    protected $dates = ['created_at', 'updated_at'];

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

    public function validate($data)
    {
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

    public function errors()
    {
        return $this->errors;
    }

    public function mensalidade()
    {
        return $this->belongsTo('App\Mensalidade', 'id_mensalidade');
    }

    public function abertura_empresa()
    {
        return $this->belongsTo('App\AberturaEmpresa', 'id_abertura_empresa');
    }

    public function historico_pagamentos()
    {
        return $this->hasMany('App\Pagamento', 'id_mensalidade');
    }

    public function botao_pagamento()
    {
        try {
            if ($this->status == 'Devolvida' || $this->status == 'Cancelada' || $this->status == 'Pendente' || $this->status == 'Aguardando pagamento') {
                $name = Auth::user()->nome;


                if (!strpos(trim($name), ' ')) {
                    $name = $name . ' ' . $name;

                }
                $data = [
                    'timeout' => 30,
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
        } catch (FatalErrorException $exception) {
            Log::critical('Timeout de pagamento para pagamento de solicitação de ' . $this->empresa->usuario->nome);
        }
        return null;
    }

}
