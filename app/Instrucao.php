<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Instrucao extends Model {

    use SoftDeletes;

    protected $rules = ['descricao' => 'required', 'ordem' => 'required|integer'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'ordem' => 'Ordem'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'instrucao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao', 'ordem', 'id_imposto'];

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

    public function imposto() {
        return $this->belongsTo('App\Imposto', 'id_imposto','id');
    }

}
