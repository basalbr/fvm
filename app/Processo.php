<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Processo extends Model {

    use SoftDeletes;

    protected $rules = ['id_pessoa' => 'required', 'competencia'=>'required', 'id_imposto'];
    protected $errors;
    protected $niceNames = ['competencia' => 'Competência'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'processo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_pessoa', 'competencia', 'id_imposto'];

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
    
    public function processo_respostas(){
        return $this->hasMany('App\ProcessoResposta', 'id_processo');
    }
    
    public function imposto()
    {
        return $this->belongsTo('App\Imposto','id_imposto');
    }

}
