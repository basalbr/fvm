<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ChamadoResposta extends Model {

    use SoftDeletes;

    protected $rules = ['mensagem' => 'required'];
    protected $errors;
    protected $niceNames = ['mensagem' => 'Mensagem'];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chamado_resposta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mensagem', 'id_usuario', 'id_chamado', 'anexo'];

    public function enviar_notificacao_nova_mensagem_chamado() {
        $remetente = $this->usuario;
        $email_usuario = $this->chamado->usuario->email;
        if ($remetente->admin) {
            $notificacao = new Notificacao;
            $notificacao->mensagem = 'Você possui uma nova mensagem no chamado: ' . $this->chamado->titulo . '. <a href="' . route('responder-chamado-usuario', ['id' => $this->id_chamado]) . '">Visualizar.</a>';
            $notificacao->id_usuario = $this->chamado->id_usuario;
            $notificacao->save();
        }
        try {
            if ($remetente->admin) {
                \Illuminate\Support\Facades\Mail::send('emails.nova-mensagem-chamado', ['nome' => $remetente->nome, 'id_chamado' => $this->id_chamado], function ($m) use ($email_usuario) {
                    $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                    $m->to($email_usuario)->subject('Nova Mensagem');
                });
            } else {
                \Illuminate\Support\Facades\Mail::send('emails.nova-mensagem-chamado-admin', ['nome' => $remetente->nome, 'id_chamado' => $this->id_chamado], function ($m) {
                    $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                    $m->to('admin@webcontabilidade.com')->subject('Nova Mensagem');
                });
            }
        } catch (\Exception $ex) {
            return true;
        }
    }

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

    public function chamado() {
        return $this->belongsTo('App\Chamado', 'id_chamado');
    }

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

}
