<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Pessoa extends Model {

    use SoftDeletes;

    protected $rules = [
        'id_usuario' => 'required',
        'id_natureza_juridica' => 'required',
        'cpf_cnpj' => 'required|unique:pessoa,cpf_cnpj',
        'inscricao_estadual' => 'required|unique:pessoa,inscricao_estadual',
        'inscricao_municipal' => 'required|unique:pessoa,inscricao_municipal',
        'iptu' => 'required',
        'qtde_funcionarios' => 'required|numeric',
        'tipo' => 'required',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required',
        'cidade' => 'required',
        'numero' => 'numeric',
        'id_uf' => 'required',
        'codigo_acesso_simples_nacional' => 'numeric',
        'nome_fantasia' => 'required',
        'razao_social' => 'required',
        'id_tipo_tributacao' => 'required'
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
        'id_uf',
        'codigo_acesso_simples_nacional',
        'nome_fantasia',
        'razao_social',
        'numero',
        'codigo_acesso_simples_nacional',
        'id_tipo_tributacao'
    ];

    public function validate($data, $update = false) {
        // make a new validator object
        if($update){
            $this->rules['cpf_cnpj'] = 'required|unique:pessoa,cpf_cnpj,'.$data['id'];
            $this->rules['inscricao_municipal'] = 'required|unique:pessoa,inscricao_municipal,'.$data['id'];
            $this->rules['inscricao_estadual'] = 'required|unique:pessoa,inscricao_estadual,'.$data['id'];
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

    public function processos() {
        return $this->hasMany('App\Processo', 'id_pessoa');
    }
    
    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

}
