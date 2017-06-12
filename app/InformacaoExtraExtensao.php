<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class InformacaoExtraExtensao extends Model {


    protected $rules = ['id_informacao_extra' => 'required', 'extensao' => 'required'];
    protected $errors;
    protected $niceNames = ['extensao' => 'Extensão'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'informacao_extra_extensao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_informacao_extra', 'extensao'];

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

    public function extensoes() {
        return $this->belongsTo('App\InformacaoExtra', 'id_informacao_extra','id');
    }

}
