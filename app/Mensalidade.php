<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Mensalidade extends Model {

    use SoftDeletes;

    protected $rules = ['id_usuario' => 'required', 'id_pessoa' => 'required', 'duracao' => 'required', 'valor' => 'required|numeric', 'tipo' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'];

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
    protected $fillable = ['id_usuario', 'id_pessoa', 'valor', 'duracao', 'documentos_fiscais', 'documentos_contabeis', 'pro_labores', 'funcionarios', 'status'];

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

    public function proximo_pagamento() {
        try {
            $data_vencimento = date_format($this->created_at, 'd');
            $ultimo_pagamento = date_format($this->pagamentos()->orderBy('created_at', 'desc')->first()->created_at, 'Y-m');
            $date = strtotime("+5 days +1 month", strtotime($ultimo_pagamento . '-' . $data_vencimento));
            return date("d/m/Y", $date);
        } catch (Exception $ex) {
            return false;
        }
    }

    public function abrir_ordem_pagamento() {
        try {
            $data_vencimento = date_format($this->created_at, 'd');
            $ultimo_pagamento = date_format($this->pagamentos()->orderBy('created_at', 'desc')->first()->created_at, 'Y-m');
            $date = strtotime("+1 month", strtotime($ultimo_pagamento . '-' . $data_vencimento));
            $vencimento = date('Y-m-d',strtotime("+5 days", $date));
            
            if (date('Ymd') == date('Ymd', $date)) {
                
                if ($this->empresa->status == 'Aprovado') {
                    echo date('Ymd', $date);
                    $pagamento = new \App\Pagamento;
                    $pagamento->id_mensalidade = $this->id;
                    $pagamento->status = 'Pendente';
                    $pagamento->valor = $this->valor;
                    $pagamento->vencimento = $vencimento;
                    $pagamento->save();
                }
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function pagamentos() {
        return $this->hasMany('App\Pagamento', 'id_mensalidade');
    }

    public function empresa() {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

}
