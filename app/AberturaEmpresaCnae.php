<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class AberturaEmpresaCnae extends Model {


    protected $rules = ['id_abertura_empresa' => 'required', 'id_cnae' => 'required'];
    protected $errors;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abertura_empresa_cnae';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_abertura_empresa', 'id_cnae'];

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
    
    public function empresa(){
        return $this->belongsTo('App\AberturaEmpresa', 'id_abertura_empresa');
    }
    
    public function cnae(){
        return $this->belongsTo('App\Cnae', 'id_cnae');
    }

}
