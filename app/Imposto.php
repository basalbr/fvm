<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Imposto extends Model {

    use SoftDeletes;

    protected $rules = ['nome' => 'required', 'vencimento' => 'required'];
    protected $errors;
    protected $niceNames = ['nome' => 'Nome', 'vencimento' => 'Vencimento'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imposto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'vencimento', 'antecipa_posterga', 'recebe_documento'];

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

    public function meses() {
        $this->hasMany('App\ImpostoMes', 'id_imposto');
    }

}