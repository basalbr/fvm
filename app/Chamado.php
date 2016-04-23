<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Chamado extends Model {

    use SoftDeletes;

    protected $rules = ['titulo' => 'required', 'mensagem' => 'required'];
    protected $errors;
    protected $niceNames = ['titulo' => 'Título', 'mensagem' => 'Mensagem'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chamado';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['titulo', 'mensagem', 'id_usuario'];

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
    
    public function chamado_respostas(){
        return $this->hasMany('App\ChamadoResposta', 'id_chamado');
    }
    
    public function usuario()
    {
        return $this->belongsTo('App\Usuario','id_usuario');
    }

}
