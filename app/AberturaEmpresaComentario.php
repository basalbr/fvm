<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
class AberturaEmpresaComentario extends Model {

    use SoftDeletes;

    protected $rules = [
        'id_usuario' => 'sometimes|required',
        'anexo' => 'sometimes|required',
        'mensagem' => 'required',
    ];
    protected $errors;
    protected $niceNames = [
        'anexo' => 'Anexo',
        'mensagem' => 'Mensagem',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abertura_empresa_comentario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'anexo',
        'mensagem',
    ];

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

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }
    
        public function empresa() {
        return $this->belongsTo('App\AberturaEmpresa', 'id_abertura_empresa');
    }
    
     
}
