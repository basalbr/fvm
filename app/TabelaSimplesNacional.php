<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class TabelaSimplesNacional extends Model {

    use SoftDeletes;

    protected $rules = ['descricao' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tabela_simples_nacional';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao'];


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
