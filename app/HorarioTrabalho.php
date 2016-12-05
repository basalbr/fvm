<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class HorarioTrabalho extends Model {

    use SoftDeletes;

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
    protected $table = 'horario_trabalho';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_contrato_trabalho',
        'hora1',
        'hora2',
        'hora3',
        'hora4',
        'dia'
    ];

    public function validate($data, $update = false) {
        // make a new validator object
        if ($update) {
            $this->rules['cpf'] = 'required|unique:socio,cpf,' . $data['id'];
            $this->rules['rg'] = 'required|unique:socio,rg,' . $data['id'];
            $this->rules['id_pessoa'] = '';
            $this->rules['principal'] = '';
        }
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

    public function salario_formatado() {
        return number_format($this->salario, 2, ',', '.');
    }

}
