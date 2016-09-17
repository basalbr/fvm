<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class InformacaoExtra extends Model {

    use SoftDeletes;

    protected $rules = ['tipo' => 'required', 'nome' => 'required','tamanho_maximo' => 'integer', 'id_imposto'=>'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'tamanho_maximo' => 'Tamanho Máximo', 'nome'=>'Nome', 'tabela'=>'Tabela', 'campo'=>'Campo', 'tipo'=>'Tipo'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'informacao_extra';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_imposto', 'tipo', 'nome', 'descricao', 'tamanho_maximo', 'tabela','campo'];

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

    public function errors() {
        return $this->errors;
    }

    public function extensoes() {
        return $this->hasMany('App\InformacaoExtraExtensao', 'id_informacao_extra','id');
    }
    
    public function tipo_formatado(){
        if($this->tipo == 'dado_integrado'){
            return 'Dado Integrado';
        }
        if($this->tipo == 'anexo'){
            return 'Anexo';
        }
        if($this->tipo == 'informacao_extra'){
            return 'Informação Extra';
        }
    }
    

}
