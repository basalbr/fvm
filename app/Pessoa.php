<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Pessoa extends Model
{

    use SoftDeletes;

    protected $rules = [
        'id_usuario' => 'required',
        'id_natureza_juridica' => 'required',
        'cpf_cnpj' => 'required|unique:pessoa,cpf_cnpj|size:18',
        'inscricao_estadual' => 'unique:pessoa,inscricao_estadual',
        'inscricao_municipal' => 'unique:pessoa,inscricao_municipal',
        'qtde_funcionarios' => 'required|numeric',
        'tipo' => 'required',
        'endereco' => 'required',
        'bairro' => 'required',
        'cep' => 'required|size:9',
        'cidade' => 'required',
        'numero' => 'numeric',
        'id_uf' => 'required',
        'codigo_acesso_simples_nacional' => 'numeric',
        'nome_fantasia' => 'required',
        'razao_social' => 'required|unique:pessoa,razao_social',
        'id_tipo_tributacao' => 'required',
        'crc' => 'required|sometimes'
    ];
    protected $errors;
    protected $niceNames = [
        'id_natureza_juridica' => 'Natureza Jurídica',
        'cpf_cnpj' => 'CNPJ',
        'inscricao_estadual' => 'Inscrição Estadual',
        'inscricao_municipal' => 'Inscrição Municipal',
        'qtde_funcionarios' => 'Quantidade de Funcionários',
        'tipo' => 'tipo',
        'endereco' => 'Endereço',
        'bairro' => 'Bairro',
        'cep' => 'Cep',
        'cidade' => 'Cidade',
        'numero' => 'Número',
        'id_uf' => 'Estado',
        'codigo_acesso_simples_nacional' => 'Código de Acesso do Simples Nacional',
        'nome_fantasia' => 'Nome Fantasia',
        'razao_social' => 'Razão Social',
        'id_tipo_tributacao' => 'Tipo de Tributação',
        'crc' => 'Número de registro do CRC do contador atual'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pessoa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'id_natureza_juridica',
        'cpf_cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'iptu',
        'rg',
        'qtde_funcionarios',
        'email',
        'telefone',
        'responsavel',
        'tipo',
        'endereco',
        'bairro',
        'cep',
        'cidade',
        'id_uf',
        'codigo_acesso_simples_nacional',
        'nome_fantasia',
        'razao_social',
        'numero',
        'codigo_acesso_simples_nacional',
        'id_tipo_tributacao',
        'crc'
    ];

    public function validate($data, $update = false)
    {
        // make a new validator object
        if ($update) {
            $this->rules['cpf_cnpj'] = 'required|unique:pessoa,cpf_cnpj,' . $data['id'];
            $this->rules['inscricao_municipal'] = 'unique:pessoa,inscricao_municipal,' . $data['id'];
            $this->rules['inscricao_estadual'] = 'unique:pessoa,inscricao_estadual,' . $data['id'];
            $this->rules['razao_social'] = 'required|unique:pessoa,razao_social,' . $data['id'];
            $this->rules['id_usuario'] = '';
            $this->rules['id_natureza_juridica'] = '';
            $this->rules['id_tipo_tributacao'] = '';
            $this->rules['tipo'] = '';
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

    public function criar_mensalidade($request)
    {
        $plano = \App\Plano::where('total_documentos', '>=', $request->get('total_documentos'))->where('total_documentos_contabeis', '>=', $request->get('total_contabeis'))->where('pro_labores', '>=', $request->get('pro_labores'))->orderBy('valor', 'asc')->first();
        $valor = $plano->valor;
        if ($request->get('funcionarios')) {
            if ($request->get('funcionarios') >= 10) {
                $valor = $plano->valor + ($request->get('funcionarios') * 20);
            } else {
                $valor = $plano->valor + ($request->get('funcionarios') * 25);
            }
        }
        $mensalidade = new \App\Mensalidade;
        $mensalidade->id_usuario = $this->id_usuario;
        $mensalidade->id_pessoa = $this->id;
        $mensalidade->duracao = $plano->duracao;
        $mensalidade->valor = $valor;
        $mensalidade->documentos_fiscais = $plano->total_documentos;
        $mensalidade->documentos_contabeis = $plano->total_documentos_contabeis;
        $mensalidade->pro_labores = $plano->pro_labores;
        $mensalidade->funcionarios = $request->get('funcionarios') ? $request->get('funcionarios') : 0;
        $mensalidade->status = 'Pendente';
        $mensalidade->save();
    }

    public function iniciar_periodo_gratis()
    {
        $mensalidade = Mensalidade::where('id_pessoa', '=', $this->id)->first();
        $pagamento = new \App\Pagamento;
        $pagamento->tipo = 'mensalidade';
        $pagamento->id_mensalidade = $mensalidade->id;
        $pagamento->valor = $mensalidade->valor;
        $pagamento->status = 'Paga';
        $pagamento->vencimento = date('Y-m-d H:i:s', strtotime("+7 day"));
        $pagamento->save();
        $mensalidade->created_at = date('Y-m-d H:i:s');
        $mensalidade->status = 'Aprovado';
        $mensalidade->save();
    }

    public function abrir_processos()
    {
        $impostos_mes = \App\ImpostoMes::where('mes', '=', (date('n') - 1))->get();
        $competencia = date('Y-m-d', strtotime(date('Y-m') . " -1 month"));
        if (count($impostos_mes)) {
            foreach ($impostos_mes as $imposto_mes) {
                if ($this->status == 'Aprovado') {

                    $imposto = $imposto_mes->imposto;
                    $processo = new Processo;
                    $processo = $processo->create([
                        'id_pessoa' => $this->id,
                        'competencia' => $competencia,
                        'id_imposto' => $imposto_mes->id_imposto,
                        'vencimento' => $imposto->corrigeData(date('Y') . '-' . date('m') . '-' . $imposto->vencimento, 'Y-m-d'),
                        'status' => 'novo'
                    ]);
                    $usuario = $this->usuario;
                    $notificacao = new Notificacao;
                    $notificacao->mensagem = '<a href="' . $processo->id . '">Você possui uma nova apuração. Clique aqui para visualizar.</a>';
                    $notificacao->id_usuario = $this->id_usuario;
                    $notificacao->save();
                    try {
                        \Illuminate\Support\Facades\Mail::send('emails.novo-processo', ['nome' => $usuario->nome, 'id_processo' => $processo->id], function ($m) use ($usuario) {
                            $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                            $m->to($usuario->email)->subject('Você Possui Uma Nova Apuração');
                        });
                        \Illuminate\Support\Facades\Mail::send('emails.novo-processo-admin', ['nome' => $this->nome_fantasia, 'id_processo' => $processo->id], function ($m) {
                            $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                            $m->to('admin@webcontabilidade.com')->subject('Uma nova apuração foi aberta');
                        });
                    } catch (\Exception $ex) {
                        return true;
                    }
                }
            }
        }
    }

    public function abrir_processos_contabeis()
    {
        $periodo = date('Y-m-01', strtotime(date('Y-m') . " -1 month"));
        $processo = ProcessoDocumentoContabil::where('periodo', '=', $periodo)->where('id_pessoa', '=', $this->id)->first();
        if (!$processo instanceof ProcessoDocumentoContabil) {
            $processo = new ProcessoDocumentoContabil;
            $processo->create(['periodo' => $periodo, 'id_pessoa' => $this->id, 'status' => 'pendente']);
            $notificacao = new Notificacao;
            $notificacao->mensagem = '<a href="' . $processo->id . '">Você possui uma nova solicitação de documentos contábeis. Clique aqui para visualizar.</a>';
            $notificacao->id_usuario = $this->id_usuario;
            $notificacao->save();
            $usuario = $this->usuario;
            try {
                \Illuminate\Support\Facades\Mail::send('emails.novo-processo-documento-contabil', ['nome' => $usuario->nome, 'id_processo' => $processo->id], function ($m) use ($usuario) {
                    $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                    $m->to($usuario->email)->subject('Você Possui Uma Nova Apuração');
                });
            } catch (\Exception $ex) {

                return true;
            }
        }
    }

    public function enviar_notificacao_status()
    {
        $usuario = $this->usuario;
        $notificacao = new Notificacao;
        $notificacao->mensagem = '<a href="' . route('editar-empresa', [$this->id]) . '">A empresa ' . $this->nome_fantasia . ' mudou seu status para ' . $this->status . '. Clique aqui para visualizar a empresa.</a>';
        $notificacao->id_usuario = $usuario->id;
        $notificacao->save();
        try {
            \Illuminate\Support\Facades\Mail::send('emails.status-empresa', ['nome' => $usuario->nome, 'id_empresa' => $this->id, 'nome_empresa' => $this->nome_fantasia, 'status' => $this->status], function ($m) use ($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Mudança de Status em Empresa');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function enviar_notificacao_nova_empresa()
    {
        $usuario = Auth::user();
        try {
            \Illuminate\Support\Facades\Mail::send('emails.nova-empresa', ['nome' => $usuario->nome, 'empresa' => $this], function ($m) use ($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to($usuario->email)->subject('Nova empresa cadastrada');
            });
            \Illuminate\Support\Facades\Mail::send('emails.nova-empresa-admin', ['nome' => $usuario->nome, 'empresa' => $this], function ($m) use ($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Nova migração de empresa');
            });
        } catch (\Exception $ex) {
            return true;
        }
    }

    public function isSimplesNacional()
    {
        if ($this->cnaes->count() > 0) {
            foreach ($this->cnaes as $cnae) {
                if ($cnae->cnae->id_tabela_simples_nacional == null) {
                    return false;
                }
            }
            return true;
        }
    }

    public function errors()
    {
        return $this->errors;
    }

    public function cnaes()
    {
        return $this->hasMany('App\PessoaCnae', 'id_pessoa');
    }

    public function socios()
    {
        return $this->hasMany('App\Socio', 'id_pessoa');
    }

    public function funcionarios()
    {
        return $this->hasMany('App\Funcionario', 'id_pessoa');
    }

    public function processos()
    {
        return $this->hasMany('App\Processo', 'id_pessoa');
    }

    public function mensalidade()
    {
        return $this->hasOne('App\Mensalidade', 'id_pessoa');
    }

    public function processos_documentos_contabeis()
    {
        return $this->hasMany('App\ProcessoDocumentoContabil', 'id_pessoa');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

    public function delete()
    {

        if ($this->processos->count()) {
            foreach ($this->processos as $processo) {
                $processo->delete();
            }
        }
        if ($this->processos_documentos_contabeis->count()) {
            foreach ($this->processos_documentos_contabeis as $processo) {
                $processo->delete();
            }
        }

        if ($this->funcionarios->count()) {
            foreach ($this->funcionarios as $funcionarios) {
                $funcionarios->delete();
            }
        }

        if ($this->socios->count()) {
            foreach ($this->socios as $socios) {
                $socios->delete();
            }
        }

        parent::delete();
    }

    public function socio_principal()
    {
        return $this->socios()->where('principal', '=', true)->first();
    }

    public function canRegisterFuncionario()
    {
        return $this->funcionarios->count() < $this->mensalidade->funcionarios;
    }


}
