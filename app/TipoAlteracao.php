<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class TipoAlteracao extends Model {

    use SoftDeletes;

    protected $rules = ['descricao' => 'required', 'valor'=>'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição','valor'=>'Valor'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipo_alteracao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao','valor'];


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

    public function campos(){
        return $this->hasMany('App\AlteracaoCampo','id_tipo_alteracao');
    }
    
    public function valor_formatado() {
        $format = new \NumberFormatter("pt-BR", \NumberFormatter::CURRENCY);
        return $format->format($this->valor);
    }
    
    public function alteracoes(){
        return $this->hasMany('App\Alteracao','id_tipo_alteracao');
    }
}
