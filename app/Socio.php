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
        'principal' => 'required|boolean',
        'cpf' => 'required|unique:socio,cpf',
        'rg' => 'required|unique:socio,rg',
        'titulo_eleitor' => 'required',
        'recibo_ir' => 'required',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required',
        'cidade' => 'required',
        'numero' => 'numeric',
        'id_uf' => 'required',
        'pro_labore' => 'numeric',
        'orgao_expedidor' => 'required',
    ];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'representante' => 'Representante', 'qualificacao' => 'Qualificação'];

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
    ];

    public function validate($data, $update = false) {
        // make a new validator object
        if($update){
            $this->rules['cpf'] = 'required|unique:socio,cpf,'.$data['id'];
            $this->rules['rg'] = 'required|unique:socio,rg,'.$data['id'];
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

    public function pessoa() {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

}
