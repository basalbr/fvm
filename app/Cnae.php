<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Cnae extends Model {

    use SoftDeletes;

    protected $rules = ['descricao' => 'required', 'codigo' => 'required', 'id_tabela_simples_nacional' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'codigo' => 'Código', 'id_tabela_simples_nacional' => 'Tabela do simples nacional'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cnae';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_tabela_simples_nacional', 'descricao', 'codigo'];

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

    public function tabela_simples_nacional() {
        return $this->belongsTo('App\TabelaSimplesNacional', 'id_tabela_simples_nacional');
    }

}
