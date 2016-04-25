<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Imposto extends Model {

    use SoftDeletes;

    protected $rules = ['nome' => 'required', 'vencimento' => 'required|integer', 'antecipa_posterga' => 'required', 'recebe_documento'=>'required'];
    protected $errors;
    protected $niceNames = ['nome' => 'Nome', 'vencimento' => 'Dia do Vencimento', 'antecipa_posterga'=>'Antecipa ou posterga', 'recebe_documento'=>'Receber documentos'];
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
        return $this->hasMany('App\ImpostoMes', 'id_imposto');
    }

}
