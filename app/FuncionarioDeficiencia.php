<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class FuncionarioDeficiencia extends Model {

    public $timestamps = false;
    protected $rules = [
    ];
    protected $errors;
    protected $niceNames = [
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'funcionario_deficiencia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_funcionario',
        'deficiencia'
    ];

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

    public function funcionario() {
        return $this->belongsTo('App\Funcionario', 'id_funcionario');
    }

}
