<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Mensalidade extends Model {

    use SoftDeletes;

    protected $rules = ['id_usuario' => 'required', 'id_pessoa' => 'required', 'duracao' => 'required','valor' => 'required|numeric', 'tipo' => 'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'valor' => 'Valor', 'nome' => 'Nome', 'duracao' => 'Duração'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mensalidade';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario', 'id_pessoa', 'valor', 'duracao', 'documentos_fiscais','documentos_contabeis', 'pro_labores', 'funcionarios','status'];

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

}
