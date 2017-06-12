<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Prolabore extends Model {

    use SoftDeletes;

    protected $rules = ['pro_labore'=>'required', 'inss'=>'required','valor_pro_labore'=>'required'];
    protected $errors;
    protected $niceNames = ['pro_labore' => 'Pró-Labore', 'inss'=>'INSS','irrf'=>'IRRF', 'pro_labore_valo' => 'Valor do Pró-Labore'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pro_labore';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_socio','inss', 'irrf', 'pro_labore', 'valor_pro_labore','competencia'];


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

    public function socio(){
        return $this->belongsTo('App\Socio','id_socio');
    }
    
}
