<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class PessoaCnae extends Model {


    protected $rules = ['id_pessoa' => 'required', 'id_cnae' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'codigo' => 'Código', 'id_tabela_simples_nacional' => 'Tabela do simples nacional'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pessoa_cnae';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_pessoa', 'id_cnae'];

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
    
    public function pessoa(){
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }
    
    public function cnae(){
        return $this->belongsTo('App\Cnae', 'id_cnae');
    }

}
