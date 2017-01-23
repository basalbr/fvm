<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AlteracaoMensagem extends Model {

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
    protected $table = 'alteracao_mensagem';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mensagem', 'id_usuario', 'id_alteracao', 'anexo'];

    public function enviar_notificacao_nova_mensagem_alteracao() {
        $remetente = Auth::user();
        $email_usuario = $this->alteracao->empresa->usuario->email;
        if (!$remetente->admin) {
            $notificacao = new Notificacao;
            $notificacao->mensagem = 'Você possui uma nova mensagem na solicitação: ' . $this->alteracao->tipo->descricao . '. <a href="' . route('visualizar-solicitacao-alteracao', [$this->alteracao->id_pessoa, $this->alteracao->id]) . '">Visualizar.</a>';
            $notificacao->id_usuario = $this->alteracao->empresa->id_usuario;
            $notificacao->save();
        }
        try {
            if ($remetente->admin) {
                \Illuminate\Support\Facades\Mail::send('emails.nova-mensagem-alteracao', ['nome' => $this->alteracao->usuario->nome, 'id_empresa'=>$this->alteracao->id_pessoa, 'id_alteracao' => $this->id_alteracao], function ($m) use ($email_usuario) {
                    $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                    $m->to($email_usuario)->subject('Nova Mensagem');
                });
            } else {
                \Illuminate\Support\Facades\Mail::send('emails.nova-mensagem-alteracao-admin', ['nome' => $remetente->nome, 'id_alteracao' => $this->id_alteracao], function ($m) {
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

    public function alteracao() {
        return $this->belongsTo('App\Alteracao', 'id_alteracao');
    }

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

}
