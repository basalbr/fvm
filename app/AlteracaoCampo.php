<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AlteracaoCampo extends Model {

    use SoftDeletes;

    protected $rules = ['id_tipo_alteracao' => 'required', 'tipo' => 'required', 'nome' => 'required', 'descricao' => 'required'];
    protected $errors;
    protected $niceNames = ['id_tipo_alteracao' => 'Tipo de Alteração', 'nome' => 'Nome', 'descricao'=>'Descrição', 'tipo'=>'Tipo'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alteracao_campo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_tipo_alteracao', 'tipo', 'nome', 'descricao'];

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

    public function tipo_alteracao() {
        return $this->belongsTo('App\TipoAlteracao', 'id_tipo_alteracao');
    }

}
