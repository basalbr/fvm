<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ProcessoInformacaoExtra extends Model {

    use SoftDeletes;

    protected $rules = ['id_processo' => 'required', 'id_informacao_extra'=>'required', 'informacao'=>'required'];
    protected $errors;
    protected $niceNames = ['informacao' => 'Informação'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'processo_informacao_extra';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_processo', 'id_informacao_extra', 'informacao'];

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
    
    public function processo(){
        return $this->belongsTo('App\Processo', 'id_processo');
    }
    
    public function informacao_extra()
    {
        return $this->belongsTo('App\InformacaoExtra','id_informacao_extra');
    }

}
