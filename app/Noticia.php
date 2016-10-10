<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Noticia extends Model {

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $rules = ['titulo' => 'required', 'texto' => 'required', 'imagem' => 'required', 'created_at' => 'required'];
    protected $errors;
    protected $niceNames = ['titulo' => 'Título', 'texto' => 'Texto', 'imagem' => 'Imagem', 'created_at' => 'Data de Publicação'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'noticia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['titulo', 'texto', 'imagem', 'created_at'];

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
