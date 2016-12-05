<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ContratoTrabalho extends Model {

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
    protected $table = 'contrato_trabalho';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_funcionario',
        'cargo',
        'funcao',
        'departamento',
        'sindicato',
        'dsr',
        'sindicalizado',
        'pagou_contribuicao',
        'competencia_sindicato',
        'data_admissao',
        'qtde_dias_vale_transporte',
        'valor_vale_transporte',
        'valor_assistencia_medica',
        'desconto_assistencia_medica',
        'vinculo_empregaticio',
        'situacao_seguro_desemprego',
        'salario',
        'possui_banco_de_horas',
        'desconta_vale_transporte',
        'contrato_experiencia',
        'professor',
        'primeiro_emprego',
        'qtde_dias_experiencia',
        'data_inicio_experiencia',
        'data_final_experiencia',
        'data_inicio_prorrogacao_experiencia',
        'data_final_prorrogacao_experiencia',
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
    
    public function horarios(){
        return $this->hasMany('App\HorarioTrabalho','id_contrato_trabalho');
    }

    public function salario_formatado() {
        return number_format($this->salario, 2, ',', '.');
    }

}
