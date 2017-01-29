<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DocumentoContabil extends Model {

    use SoftDeletes;

    protected $rules = ['descricao' => 'required', 'anexo' => 'required', 'id_processo_documento_contabil'=>'required'];
    protected $errors;
    protected $niceNames = ['descricao' => 'Descrição', 'anexo' => 'Anexo', 'id_processo_documento_contabil' => 'Processo de Documentos Contábeis'];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documento_contabil';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao', 'anexo', 'id_processo_documento_contabil'];

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

    public function chamado_respostas() {
        return $this->hasMany('App\ChamadoResposta', 'id_chamado');
    }

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

}
