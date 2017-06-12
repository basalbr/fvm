<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Chat extends Model {

    use SoftDeletes;

    protected $rules = ['email' => 'required','nome' => 'required', 'mensagem' => 'required'];
    protected $errors;
    protected $niceNames = ['titulo' => 'Título', 'mensagem' => 'Mensagem'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'email', 'mensagem','id_usuario'];

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
    
    public function mensagens(){
        return $this->hasMany('App\ChatMensagem', 'id_chat');
    }
    
    public function usuario()
    {
        return $this->belongsTo('App\Usuario','id_usuario');
    }

}
