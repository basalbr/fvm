<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;
use App\Notificacao;
use Illuminate\Support\Facades\Auth;

class AberturaEmpresa extends Model {

    use SoftDeletes;

    protected $rules = [
        'id_usuario' => 'sometimes|required',
        'nome_empresarial1' => 'required',
        'nome_empresarial2' => 'required',
        'nome_empresarial3' => 'required',
        'enquadramento' => 'required',
        'capital_social' => 'required',
        'id_natureza_juridica' => 'required',
        'id_tipo_tributacao' => 'sometimes|required',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required|size:9',
        'cidade' => 'required',
        'numero' => 'numeric|required',
        'id_uf' => 'required',
        'iptu' => 'required',
        'area_total' => 'required|numeric',
        'area_ocupada' => 'required|numeric',
        'cpf_cnpj_proprietario' => 'required',
    ];
    protected $errors;
    protected $niceNames = [
        'nome_empresarial1' => 'Nome Empresarial Preferencial',
        'nome_empresarial2' => 'Nome Empresarial Alternativo 1',
        'nome_empresarial3' => 'Nome Empresarial Alternativo 2',
        'enquadramento' => 'Enquadramento da empresa',
        'capital_social' => 'Capital Social',
        'id_natureza_juridica' => 'Natureza Jurídica',
        'id_tipo_tributacao' => 'Tipo de Tributação',
        'endereco' => 'Endereço',
        'bairro' => 'Bairro',
        'cep' => 'CEP',
        'cidade' => 'Cidade',
        'numero' => 'Número',
        'complemento' => 'Complemento',
        'id_uf' => 'Estado',
        'iptu' => 'Inscrição IPTU ',
        'area_total' => 'Área total do imóvel m²',
        'area_ocupada' => 'Área total ocupada em m²',
        'cpf_cnpj_proprietario' => 'CPF ou CNPJ do proprietário do imóvel',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abertura_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'nome_empresarial1',
        'nome_empresarial2',
        'nome_empresarial3',
        'enquadramento',
        'capital_social',
        'id_natureza_juridica',
        'id_tipo_tributacao',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'numero',
        'complemento',
        'id_uf',
        'iptu',
        'area_total',
        'area_ocupada',
        'cpf_cnpj_proprietario',
        'status',
    ];

    public function delete() {
        if ($this->pagamento instanceof Pagamento) {
            $this->pagamento->delete();
        }
        if ($this->socios->count()) {
            foreach ($this->socios as $socio) {
                $socio->delete();
            }
        }
        if ($this->mensagens->count()) {
            foreach ($this->mensagens as $mensagem) {
                $mensagem->delete();
            }
        }
        parent::delete();
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

    public function isSimplesNacional() {
        if ($this->cnaes->count() > 0) {
            foreach ($this->cnaes as $cnae) {
                if ($cnae->cnae->id_tabela_simples_nacional == null) {
                    return false;
                }
            }
            return true;
        }
    }

    public function enviar_notificacao_criacao() {
        $usuario = Auth::user();
        $notificacao = new Notificacao;
        $notificacao->mensagem = 'Você abriu uma solicitação de abertura de empresa.';
        $notificacao->id_usuario = Auth::user()->id;
        $notificacao->save();
        try {
            \Illuminate\Support\Facades\Mail::send('emails.nova-abertura-empresa', ['nome' => $usuario->nome, 'id_empresa' => $this->id], function ($m) use($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Solicitação de Abertura de Empresa');
            });
            \Illuminate\Support\Facades\Mail::send('emails.nova-abertura-empresa-admin', ['nome' => $usuario->nome, 'id_empresa' => $this->id], function ($m) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Nova Solicitação de Abertura de Empresa');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function enviar_notificacao_nova_mensagem_usuario() {
        $usuario = \App\Usuario::where('id', '=', $this->id_usuario)->first();
        $notificacao = new Notificacao;
        $notificacao->mensagem = 'Você possui uma nova mensagem em seu processo de abertura de empresa. <a href="' . route('editar-abertura-empresa', ['id' => $this->id]) . '">Visualizar.</a>';
        $notificacao->id_usuario = Auth::user()->id;
        $notificacao->save();
        try {
            \Illuminate\Support\Facades\Mail::send('emails.nova-mensagem-abertura-empresa', ['nome' => $usuario->nome, 'id_empresa' => $this->id], function ($m) use($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Nova Mensagem em Abertura de Empresa');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function enviar_notificacao_nova_mensagem_admin() {
        $usuario = Auth::user();
        try {
            \Illuminate\Support\Facades\Mail::send('emails.nova-mensagem-abertura-empresa-admin', ['nome' => $usuario->nome, 'id_empresa' => $this->id], function ($m) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Nova Mensagem em Abertura de Empresa');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function enviar_notificacao_conclusao($nome) {
        $usuario = Auth::user();
        $notificacao = new Notificacao;
        $notificacao->mensagem = 'O processo de abertura da empresa ' . $nome . ' foi concluído.';
        $notificacao->id_usuario = Auth::user()->id;
        $notificacao->save();
        try {
            \Illuminate\Support\Facades\Mail::send('emails.conclusao-abertura-empresa', ['nome' => $usuario->nome, 'empresa' => $nome], function ($m) use($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Processo de Abertura de Empresa Concluído');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function errors() {
        return $this->errors;
    }

    public function cnaes() {
        return $this->hasMany('App\AberturaEmpresaCnae', 'id_abertura_empresa');
    }

    public function uf() {
        return $this->hasOne('App\Uf', 'id', 'id_uf');
    }

    public function pagamento() {
        return $this->hasOne('App\Pagamento', 'id_abertura_empresa');
    }

    public function natureza_juridica() {
        return $this->hasOne('App\NaturezaJuridica', 'id', 'id_natureza_juridica');
    }

    public function socios() {
        return $this->hasMany('App\AberturaEmpresaSocio', 'id_abertura_empresa');
    }

    public function mensagens() {
        return $this->hasMany('App\AberturaEmpresaComentario', 'id_abertura_empresa');
    }

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

    public function botao_pagamento() {
        if (
                ($this->status == 'Atenção' ||
                $this->status == 'Em Processamento' ||
                $this->status == 'Novo') &&
                ($this->pagamento->status == 'Devolvida' ||
                $this->pagamento->status == 'Cancelada' ||
                $this->pagamento->status == 'Pendente' ||
                $this->pagamento->status == 'Aguardando pagamento')
        ) {
            $data = [
                'items' => [
                    [
                        'id' => $this->id,
                        'description' => 'Abertura de Empresa',
                        'quantity' => '1',
                        'amount' => $this->pagamento->valor,
                    ],
                ],
                'notificationURL' => 'http://www.webcontabilidade.com/pagseguro',
                'reference' => $this->pagamento->id,
                'sender' => [
                    'email' => $this->usuario->email,
                    'name' => $this->usuario->nome,
                    'phone' => $this->usuario->telefone
                ]
            ];
            $checkout = Pagseguro::checkout()->createFromArray($data);
            $credentials = PagSeguro::credentials()->get();
            $information = $checkout->send($credentials); // Retorna um objeto de laravel\pagseguro\Checkout\Information\Information
            return '<a href="' . $information->getLink() . '" class="btn btn-success"><span class="fa fa-credit-card"></span> Clique para pagar</a>';
        }
        if ($this->status == 'Disponível' || $this->status == 'Em análise') {
            return '<a href="" class="btn btn-success" disabled>Em processamento</a>';
        }
        return null;
    }

}
