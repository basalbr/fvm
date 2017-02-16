<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Processo extends Model
{

    use SoftDeletes;

    protected $rules = ['id_pessoa' => 'required', 'competencia' => 'required', 'id_imposto' => 'required', 'vencimento' => 'required|date'];
    protected $errors;
    protected $niceNames = ['competencia' => 'Competência'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'processo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_pessoa', 'competencia', 'id_imposto', 'vencimento', 'status'];

    public function validate($data)
    {
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

    public function enviarNotificacaoNovaMensagemUsuario()
    {
        $usuario = $this->pessoa->usuario;
        try {
            \Illuminate\Support\Facades\Mail::send('emails.nova-mensagem-apuracao-usuario', ['apuracao'=>$this->imposto->nome, 'nome' => $usuario->nome, 'id_processo' => $this->id], function ($m) use ($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Nova Mensagem em Apuração');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function enviarNotificacaoNovaMensagemAdmin()
    {
        $empresa = $this->pessoa;
        try {
            \Illuminate\Support\Facades\Mail::send('emails.nova-mensagem-apuracao-admin', ['apuracao'=>$this->imposto->nome, 'nome_fantasia' => $empresa->nome_fantasia, 'id_processo' => $this->id], function ($m) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Nova Mensagem em Apuração');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function enviarNotificacaoMudancaStatus($status = null)
    {
        if (!$status) {
            $status = $this->status;
        }
        $usuario = $this->pessoa->usuario;
        $imposto = $this->imposto;
        try {
            \Illuminate\Support\Facades\Mail::send('emails.novo-status-apuracao', ['nome' => $usuario->nome, 'id_processo' => $this->id, 'imposto' => $imposto->nome, 'status' => $status], function ($m) use ($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Mudança de Status em Apuração');
            });
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return true;
        }
    }

    public function errors()
    {
        return $this->errors;
    }

    public function processo_respostas()
    {
        return $this->hasMany('App\ProcessoResposta', 'id_processo');
    }

    public function imposto()
    {
        return $this->belongsTo('App\Imposto', 'id_imposto');
    }

    public function pessoa()
    {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

    public function informacoes_extras()
    {
        return $this->hasMany('App\ProcessoInformacaoExtra', 'id_processo');
    }

    public function competencia_formatado()
    {
        return date_format(date_create($this->competencia), 'm/Y');
    }

    public function vencimento_formatado()
    {
        return date_format(date_create($this->vencimento), 'd/m/Y');
    }

}
