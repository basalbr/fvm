<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;
class AberturaEmpresa extends Model {

    use SoftDeletes;

    protected $rules = [
        'id_usuario' => 'sometimes|required',
        'nome_empresarial1' => 'required',
        'nome_empresarial2' => 'required',
        'nome_empresarial3' => 'required',
        'enquadramento' => 'required',
        'capital_social' => 'required',
        'id_natureza_juridica' => 'required',
        'id_tipo_tributacao' => 'sometimes|required',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required|size:9',
        'cidade' => 'required',
        'numero' => 'numeric|required',
        'id_uf' => 'required',
        'iptu' => 'required',
        'area_total' => 'required|numeric',
        'area_ocupada' => 'required|numeric',
        'cpf_cnpj_proprietario' => 'required',
    ];
    protected $errors;
    protected $niceNames = [
        'nome_empresarial1' => 'Nome Empresarial Preferencial',
        'nome_empresarial2' => 'Nome Empresarial Alternativo 1',
        'nome_empresarial3' => 'Nome Empresarial Alternativo 2',
        'enquadramento' => 'Enquadramento da empresa',
        'capital_social' => 'Capital Social',
        'id_natureza_juridica' => 'Natureza Jurídica',
        'id_tipo_tributacao' => 'Tipo de Tributação',
        'endereco' => 'Endereço',
        'bairro' => 'Bairro',
        'cep' => 'CEP',
        'cidade' => 'Cidade',
        'numero' => 'Número',
        'complemento' => 'Complemento',
        'id_uf' => 'Estado',
        'iptu' => 'Inscrição IPTU ',
        'area_total' => 'Área total do imóvel m²',
        'area_ocupada' => 'Área total ocupada em m²',
        'cpf_cnpj_proprietario' => 'CPF ou CNPJ do proprietário do imóvel',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abertura_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'nome_empresarial1',
        'nome_empresarial2',
        'nome_empresarial3',
        'enquadramento',
        'capital_social',
        'id_natureza_juridica',
        'id_tipo_tributacao',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'numero',
        'complemento',
        'id_uf',
        'iptu',
        'area_total',
        'area_ocupada',
        'cpf_cnpj_proprietario',
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
        return $this->hasMany('App\AberturaEmpresaCnae', 'id_abertura_empresa');
    }
    
    public function uf() {
        return $this->hasOne('App\Uf','id', 'id_uf');
    }
    public function pagamento() {
        return $this->hasOne('App\Pagamento','id_abertura_empresa');
    }
    public function natureza_juridica() {
        return $this->hasOne('App\NaturezaJuridica', 'id', 'id_natureza_juridica');
    }

    public function socios() {
        return $this->hasMany('App\AberturaEmpresaSocio', 'id_abertura_empresa');
    }
    public function mensagens() {
        return $this->hasMany('App\AberturaEmpresaComentario', 'id_abertura_empresa');
    }
   
    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }
    
     public function botao_pagamento() {
        if ($this->status_pagamento == 'Devolvida' || $this->status_pagamento == 'Cancelada' || $this->status_pagamento == 'Pendente' || $this->status_pagamento == 'Aguardando pagamento') {
            $data = [
                'items' => [
                    [
                        'id' => $this->id,
                        'description' => 'Abertura de Empresa',
                        'quantity' => '1',
                        'amount' => $this->pagamento->valor,
                    ],
                ],
                'notificationURL' => 'http://www.webcontabilidade.com/pagseguro',
                'reference' => $this->pagamento->id,
                'sender' => [
                    'email' => $this->usuario->email,
                    'name' => $this->usuario->nome,
                    'phone' => $this->usuario->telefone
                ]
            ];
            $checkout = Pagseguro::checkout()->createFromArray($data);
            $credentials = PagSeguro::credentials()->get();
            $information = $checkout->send($credentials); // Retorna um objeto de laravel\pagseguro\Checkout\Information\Information
            return '<a href="'.$information->getLink().'" class="btn btn-success">Clique para pagar</a>';
        }
        if ($this->status == 'Disponível' || $this->status == 'Em análise') {
            return '<a href="" class="btn btn-success" disabled>Em processamento</a>';
        }
        return null;
    }

}
