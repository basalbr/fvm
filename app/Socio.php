<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Socio extends Model {

    use SoftDeletes;

    protected $rules = [
        'nome' => 'required',
        'principal' => 'required',
        'cpf' => 'required|size:14|unique:socio,cpf',
        'rg' => 'required|unique:socio,rg',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required|size:9',
        'cidade' => 'required',
        'numero' => 'numeric',
        'id_uf' => 'required',
        'pro_labore' => 'numeric',
        'orgao_expedidor' => 'required',
        'pis' => 'size:14',
        'data_nascimento' => 'required|date',
        'titulo_eleitor' => 'required',
    ];
    protected $errors;
    protected $niceNames = [
        'nome' => 'Nome',
        'principal' => 'Sócio Principal',
        'cpf' => 'CPF',
        'rg' => 'RG',
        'titulo_eleitor' => 'Título de Eleitor',
        'endereco' => 'Endereço',
        'bairro' => 'Bairro',
        'cep' => 'CEP',
        'cidade' => 'Cidade',
        'numero' => 'Número',
        'id_uf' => 'Estado',
        'pro_labore' => 'Pró-Labore',
        'orgao_expedidor' => 'Órgão Expedidor',
        'pis' => 'PIS',
        'data_nascimento' => 'Data de Nascimento',
    ];
      protected $niceNamesPrincipal = [
        'nome' => 'Nome do Responsável',
        'principal' => 'Sócio Principal',
        'cpf' => 'CPF do Responsável',
        'rg' => 'RG do Responsável',
        'titulo_eleitor' => 'Nº Título de Eleitor do Responsável',
        'endereco' => 'Endereço do Responsável',
        'bairro' => 'Bairro do Responsável',
        'cep' => 'CEP do Responsável',
        'cidade' => 'Cidade do Responsável',
        'numero' => 'Número',
        'id_uf' => 'Estado do Responsável',
        'pro_labore' => 'Pró-Labore',
        'orgao_expedidor' => 'Órgão Expedidor do RG (Ex: SSP/SC) ',
        'pis' => 'PIS',
        'data_nascimento' => 'Data de Nascimento',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'socio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pessoa',
        'nome',
        'pis',
        'principal',
        'cpf',
        'rg',
        'titulo_eleitor',
        'recibo_ir',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'numero',
        'id_uf',
        'pro_labore',
        'orgao_expedidor',
        'telefone',
        'data_nascimento'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_nascimento'];

    public function validate($data, $update = false, $cadastro_empresa = false) {
        // make a new validator object
        if ($update) {
            $this->rules['cpf'] = 'required|unique:socio,cpf,' . $data['id'];
            $this->rules['rg'] = 'required|unique:socio,rg,' . $data['id'];
            $this->rules['id_pessoa'] = '';
            $this->rules['principal'] = '';
        }
        $v = Validator::make($data, $this->rules);
        if($cadastro_empresa){
            $v->setAttributeNames($this->niceNamesPrincipal);
        }else{
            $v->setAttributeNames($this->niceNames);
        }
        
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

    public function pessoa() {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }
    public function uf() {
        return $this->belongsTo('App\Uf', 'id_uf');
    }

    public function pro_labores() {
        return $this->hasMany('App\Prolabore', 'id_socio');
    }

    public function pro_labore_formatado() {
        return number_format($this->pro_labore, 2, ',', '.');
    }

}
