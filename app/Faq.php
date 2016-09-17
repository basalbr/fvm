<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Faq extends Model {

    use SoftDeletes;

    protected $rules = ['local' => 'required','pergunta'=>'required','resposta'=>'required'];
    protected $errors;
    protected $niceNames = ['local' => 'Local', 'pergunta'=>'Pergunta','resposta'=>'Resposta'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faq';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['local','pergunta','resposta'];


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
