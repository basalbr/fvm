<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Usuario extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword,
        SoftDeletes;

    protected $rules = ['nome' => 'required', 'email' => 'required|unique:usuario,email','senha'=>'required|confirmed'];
    protected $errors;
    protected $niceNames = ['nome' => 'Nome', 'email' => 'E-mail', 'senha'=>'Senha','senha_confirmed'=>'Confirmar Senha'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'email', 'senha', 'telefone'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['senha', 'remember_token'];

    
      public function validate($data, $update = false) {
        // make a new validator object
        if($update){
            $this->rules['senha'] = 'confirmed';
            $this->rules['email'] = 'required|unique:usuario,email,'.$data['id'];
        }
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
    
    public function getAuthPassword() {
        return $this->attributes['senha']; //change the 'passwordFieldinYourTable' with the name of your field in the table
    }

    public function chamados() {
        return $this->hasMany('App\Chamado', 'id_chamado');
    }

    public function pessoas() {
        return $this->hasMany('App\Pessoa', 'id_usuario');
    }

}
