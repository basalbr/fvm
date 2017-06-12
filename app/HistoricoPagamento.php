<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class HistoricoPagamento extends Model {

    use SoftDeletes;

    protected $rules = ['id_mensalidade' => 'required', 'status' => 'required', 'vencimento' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'historico_pagamento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['transaction_id', 'status', 'id_pagamento','forma_pagamento'];

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
}
