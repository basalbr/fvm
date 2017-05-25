<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ContratoTrabalho extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $rules = [
        'sindicato' => 'required',
        'dsr' => 'required',
        'data_admissao' => 'required',
        'qtde_dias_vale_transporte' => 'required',
        'valor_vale_transporte' => 'required',
        'valor_assistencia_medica' => 'required',
        'desconto_assistencia_medica' => 'required',
        'vinculo_empregaticio' => 'required',
        'situacao_seguro_desemprego' => 'required',
        'salario' => 'required',
        'qtde_dias_experiencia' => 'required',
    ];
    protected $errors = [];
    protected $niceNames = [
        'sindicato' => 'Sindicato',
        'dsr' => 'D.S.R',
        'data_admissao' => 'Data de admissão',
        'qtde_dias_vale_transporte' => 'Quantidade de Dias que recebe Vale Transporte',
        'valor_vale_transporte' => 'Valor de Vale Transporte',
        'valor_assistencia_medica' => 'Assistência Médica',
        'desconto_assistencia_medica' => 'Desconto de Assistência Médica',
        'vinculo_empregaticio' => 'Vínculo empregatício',
        'situacao_seguro_desemprego' => 'Situação do Seguro Desemprego',
        'salario' => 'Salário (R$)',
        'qtde_dias_experiencia' => 'Quantidade de dias de experiência',
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

    public function validate($data, $update = false)
    {
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

    public function errors()
    {
        return $this->errors;
    }

    public function setDataInicioExperiencia($value)
    {
        $this->attributes['data_inicio_experiencia'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setDataFinalExperiencia($value)
    {
        $this->attributes['data_final_experiencia'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setDataInicioProrrogacaoExperiencia($value)
    {
        $this->attributes['data_inicio_prorrogacao_experiencia'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setDataFinalProrrogacaoExperiencia($value)
    {
        $this->attributes['data_final_prorrogacao_experiencia'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setDataAdmissao($value)
    {
        $this->attributes['data_admissao'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setCompetenciaSindicato($value)
    {
        $this->attributes['competencia_sindicato'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function funcionario()
    {
        return $this->belongsTo('App\Funcionario', 'id_funcionario');
    }

    public function horarios()
    {
        return $this->hasMany('App\HorarioTrabalho', 'id_contrato_trabalho');
    }

    public function salario_formatado()
    {
        return number_format($this->salario, 2, ',', '.');
    }

}
