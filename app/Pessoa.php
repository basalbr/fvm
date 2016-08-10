<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Pessoa extends Model {

    use SoftDeletes;

    protected $rules = [
        'id_usuario' => 'required',
        'id_natureza_juridica' => 'required',
        'cpf_cnpj' => 'required',
        'inscricao_estadual' => 'required',
        'inscricao_municipal' => 'required',
        'iptu' => 'required',
        'qtde_funcionarios' => 'required',
        'email' => 'required',
        'telefone' => 'required',
        'responsavel' => 'required',
        'tipo' => 'required',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required',
        'cidade' => 'required',
        'estado' => 'required',
        'cnaes' => 'required',
        'nome_fantasia' => 'required',
        'razao_social' => 'required'
    ];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'representante' => 'Representante', 'qualificacao' => 'Qualificação'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pessoa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'id_natureza_juridica',
        'cpf_cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'iptu',
        'rg',
        'qtde_funcionarios',
        'email',
        'telefone',
        'responsavel',
        'tipo',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'cnaes',
        'nome_fantasia',
        'razao_social'
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

    public function isSimplesNacional() {
        if ($this->cnaes->count() > 0) {
            foreach ($this->cnaes as $cnae) {
                if ($cnae->cnae->id_tabela_simples_nacional == null) {
                    return false;
                }
            }
            return true;
        }
    }

    public function errors() {
        return $this->errors;
    }

    public function cnaes() {
        return $this->hasMany('App\PessoaCnae', 'id_pessoa');
    }

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

}
