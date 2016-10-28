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
        'cpf_cnpj' => 'required|unique:pessoa,cpf_cnpj|size:18',
        'inscricao_estadual' => 'unique:pessoa,inscricao_estadual',
        'inscricao_municipal' => 'unique:pessoa,inscricao_municipal',
        'qtde_funcionarios' => 'required|numeric',
        'tipo' => 'required',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required|size:9',
        'cidade' => 'required',
        'numero' => 'numeric',
        'id_uf' => 'required',
        'codigo_acesso_simples_nacional' => 'numeric',
        'nome_fantasia' => 'required',
        'razao_social' => 'required|unique:pessoa,razao_social',
        'id_tipo_tributacao' => 'required',
        'crc' => 'required|sometimes'
    ];
    protected $errors;
    protected $niceNames = [
        'id_natureza_juridica' => 'Natureza Jurídica',
        'cpf_cnpj' => 'CNPJ',
        'inscricao_estadual' => 'Inscrição Estadual',
        'inscricao_municipal' => 'Inscrição Municipal',
        'qtde_funcionarios' => 'Quantidade de Funcionários',
        'tipo' => 'tipo',
        'endereco' => 'Endereço',
        'bairro' => 'Bairro',
        'cep' => 'Cep',
        'cidade' => 'Cidade',
        'numero' => 'Número',
        'id_uf' => 'Estado',
        'codigo_acesso_simples_nacional' => 'Código de Acesso do Simples Nacional',
        'nome_fantasia' => 'Nome Fantasia',
        'razao_social' => 'Razão Social',
        'id_tipo_tributacao' => 'Tipo de Tributação',
        'crc' => 'Número de registro do CRC do contador atual'
    ];

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
        if ($update) {
            $this->rules['cpf_cnpj'] = 'required|unique:pessoa,cpf_cnpj,' . $data['id'];
            $this->rules['inscricao_municipal'] = 'unique:pessoa,inscricao_municipal,' . $data['id'];
            $this->rules['inscricao_estadual'] = 'unique:pessoa,inscricao_estadual,' . $data['id'];
            $this->rules['razao_social'] = 'required|unique:pessoa,razao_social,' . $data['id'];
            $this->rules['id_usuario'] = '';
            $this->rules['id_natureza_juridica'] = '';
            $this->rules['id_tipo_tributacao'] = '';
            $this->rules['tipo'] = '';
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

    public function abrir_processos() {
        $impostos_mes = \App\ImpostoMes::where('mes', '=', date('n'))->get();
        $competencia = date('Y-m-d', strtotime(date('Y-m') . " -1 month"));
        if (count($impostos_mes)) {
            foreach ($impostos_mes as $imposto_mes) {
                if ($this->status == 'Aprovado') {
                    $imposto = $imposto_mes->imposto;
                    $processo = new Processo;
                    $processo->create([
                        'id_pessoa' => $this->id,
                        'competencia' => $competencia,
                        'id_imposto' => $imposto_mes->id_imposto,
                        'vencimento' => $imposto->corrigeData(date('Y') . '-' . date('m') . '-' . $imposto->vencimento, 'Y-m-d'),
                        'status' => 'novo'
                    ]);
                }
            }
        }
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

    public function socios() {
        return $this->hasMany('App\Socio', 'id_pessoa');
    }

    public function processos() {
        return $this->hasMany('App\Processo', 'id_pessoa');
    }

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

}
