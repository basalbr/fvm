<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class TipoTributacao extends Model {

    use SoftDeletes;

    protected $rules = ['descricao' => 'required','has_tabela'=>'required|boolean'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'has_tabela'=>'Precisa de Tabela do Simples Nacional'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipo_tributacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao','has_tabela'];


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

}
