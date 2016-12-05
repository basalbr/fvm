<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class FuncionarioDependente extends Model {

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
    protected $table = 'funcionario_dependente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_funcionario',
        'nome',
        'data_nascimento',
        'local_nascimento',
        'cpf',
        'rg',
        'orgao_rg',
        'tipo_dependencia',
        'matricula',
        'cartorio',
        'numero_cartorio',
        'numero_folha',
        'numero_dnv',
        'data_entrega_documento',
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

    public function funcionario() {
        return $this->belongsTo('App\Funcionario', 'id_funcionario');
    }

}
