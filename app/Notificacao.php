<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacao extends Model {

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notificacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mensagem', 'id_usuario'];

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

}
