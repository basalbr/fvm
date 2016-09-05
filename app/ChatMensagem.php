<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class ChatMensagem extends Model {

    use SoftDeletes;

    protected $rules = ['id_chat' => 'required', 'mensagem'=>'required'];
    protected $errors;
    protected $niceNames = ['mensagem' => 'Mensagem'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chat_mensagem';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mensagem', 'id_atendente', 'id_chat'];

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
    
     public function chat()
    {
        return $this->belongsTo('App\Chat','id_chat');
    }
    
     public function atendente()
    {
        return $this->belongsTo('App\Usuario','id_atendente');
    }

}
