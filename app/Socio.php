<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Socio extends Model {

    use SoftDeletes;

    protected $rules = [
        'id_pessoa' => 'required',
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
        'pis'=>'size:14'
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
        'pis'=>'PIS'
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

    public function pessoa() {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

    public function pro_labores() {
        return $this->hasMany('App\Prolabore', 'id_socio');
    }
    
    public function pro_labore_formatado(){
        return number_format($this->pro_labore, 2, ',','.');
    }

}
