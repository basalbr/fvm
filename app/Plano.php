<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Plano extends Model {

    use SoftDeletes;

    protected $rules = ['descricao' => 'required','valor'=>'required|numeric','nome'=>'required', 'duracao'=>'required|integer'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor'=>'Valor','nome'=>'Nome', 'duracao' => 'Duração'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plano';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['duracao', 'valor', 'nome', 'descricao'];


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
