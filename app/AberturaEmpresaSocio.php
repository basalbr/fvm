<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class AberturaEmpresaSocio extends Model {

    use SoftDeletes;

    protected $dates = ['data_nascimento', 'created_at', 'updated_at', 'deleted_at'];
    protected $rules = [
        'id_abertura_empresa' => 'sometimes|required',
        'nome' => 'required',
        'nome_mae' => 'required',
        'nome_pai' => 'required',
        'principal' => 'required|boolean',
        'data_nascimento' => 'required|date',
        'email' => 'required|email',
        'telefone' => 'required',
        'estado_civil' => 'required',
        'regime_casamento' => 'sometimes|required',
        'cpf' => 'required|size:14',
        'rg' => 'required',
        'nacionalidade' => 'required',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required|size:9',
        'cidade' => 'required',
        'numero' => 'required|numeric',
        'id_uf' => 'required',
        'orgao_expedidor' => 'required'
    ];
    protected $errors;
    protected $niceNames = [
        'nome' => 'required',
        'nome_mae' => 'Nome da mãe',
        'nome_pai' => 'Nome do pai',
        'principal' => 'É o sócio principal?',
        'data_nascimento' => 'Data de Nascimento',
        'email' => 'E-mail',
        'telefone' => 'Telefone',
        'estado_civil' => 'Estado civil',
        'regime_casamento' => 'Regime de casamento',
        'cpf' => 'CPF',
        'rg' => 'RG',
        'nacionalidade' => 'Nacionalidade',
        'endereco' => 'Endereço',
        'bairro' => 'Bairro',
        'cep' => 'CEP',
        'cidade' => 'Cidade',
        'numero' => 'Número',
        'complemento' => 'Complemento',
        'id_uf' => 'Estado',
        'orgao_expedidor' => 'Órgão Expedidor do RG (Ex: SSP/SC)'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abertura_empresa_socio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_abertura_empresa',
        'nome',
        'nome_mae',
        'nome_pai',
        'principal',
        'data_nascimento',
        'email',
        'telefone',
        'estado_civil',
        'regime_casamento',
        'cpf',
        'rg',
        'nacionalidade',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'numero',
        'complemento',
        'id_uf',
        'orgao_expedidor'
    ];

    public function validate($data, $update = false) {
        // make a new validator object
        if ($update) {
            $this->rules['cpf'] = 'required|unique:abertura_empresa_socio,cpf,' . $data['id'];
            $this->rules['rg'] = 'required|unique:abertura_empresa_socio,rg,' . $data['id'];
            $this->rules['id_abertura_empresa'] = '';
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

    public function empresa() {
        return $this->belongsTo('App\AberturaEmpresa', 'id_abertura_empresa');
    }

    public function uf() {
        return $this->hasOne('App\Uf', 'id', 'id_uf');
    }

    public function pro_labore_formatado() {
        return number_format($this->pro_labore, 2, ',', '.');
    }

}
