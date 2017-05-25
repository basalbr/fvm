<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Notificacao;

class Funcionario extends Model
{

    use SoftDeletes;

    protected $rules = [
        'id_pessoa' => 'required',
        'nome_completo' => 'required',
        'nome_mae' => 'required',
        'nome_pai' => 'required',
        'nacionalidade' => 'required',
        'naturalidade' => 'required',
        'grau_instrucao' => 'required',
        'grupo_sanguineo' => 'required',
        'raca_cor' => 'required',
        'sexo' => 'required',
        'data_nascimento' => 'required',
        'cpf' => 'required',
        'rg' => 'required',
        'orgao_expeditor_rg' => 'required',
        'data_emissao_rg' => 'required',
        'numero_titulo_eleitoral' => 'required',
        'zona_secao_eleitoral' => 'required',
        'email' => 'required',
        'telefone' => 'required',
        'cep' => 'required',
        'bairro' => 'required',
        'id_uf' => 'required',
        'endereco' => 'required',
        'numero' => 'required',
        'cidade' => 'required',
        'pis' => 'required',
        'data_cadastro_pis' => 'required',
        'ctps' => 'required',
        'data_expedicao_ctps' => 'required',
        'id_uf_ctps' => 'required',

    ];

    protected $dates = ['created_at', 'deleted_at', 'updated_at'];

    protected $errors = [];
    protected $niceNames = [
        'id_pessoa' => 'Empresa',
        'nome_completo' => 'Nome completo',
        'nome_mae' => 'Nome da mãe',
        'nome_pai' => 'Nome do pai',
        'nacionalidade' => 'Nacionalidade',
        'naturalidade' => 'Naturalidade',
        'grau_instrucao' => 'Grau de instrução',
        'grupo_sanguineo' => 'Grupo sanguíneo',
        'raca_cor' => 'Raça/Cor',
        'sexo' => 'Sexo',
        'data_nascimento' => 'Data de nascimento',
        'cpf' => 'CPF',
        'rg' => 'RG',
        'orgao_expeditor_rg' => 'Órgão expedidor do RG',
        'data_emissao_rg' => 'Data de emissão do RG',
        'numero_titulo_eleitoral' => 'Título eleitoral',
        'zona_secao_eleitoral' => 'Zona e seção eleitoral',
        'email' => 'E-mail',
        'telefone' => 'Telefone',
        'cep' => 'CEP',
        'bairro' => 'Bairro',
        'id_uf' => 'Estado',
        'endereco' => 'Endereço',
        'numero' => 'Número',
        'cidade' => 'Cidade',
        'pis' => 'PIS',
        'data_cadastro_pis' => 'Data de cadastro do PIS',
        'ctps' => 'CTPS',
        'data_expedicao_ctps' => 'Data de expedição da CTPS',
        'id_uf_ctps' => 'Estado de emissão do CTPS',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'funcionario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pessoa',
        'nome_completo',
        'nome_mae',
        'nome_pai',
        'nome_conjuge',
        'nacionalidade',
        'naturalidade',
        'grau_instrucao',
        'grupo_sanguineo',
        'raca_cor',
        'sexo',
        'data_nascimento',
        'cpf',
        'rg',
        'orgao_expeditor_rg',
        'data_emissao_rg',
        'numero_titulo_eleitoral',
        'zona_secao_eleitoral',
        'numero_carteira_reservista',
        'categoria_carteira_reservista',
        'numero_carteira_motorista',
        'categoria_carteira_motorista',
        'vencimento_carteira_motorista',
        'email',
        'telefone',
        'data_chegada_estrangeiro',
        'condicao_trabalhador_estrangeiro',
        'numero_processo_mte',
        'validade_carteira_trabalho',
        'casado_estrangeiro',
        'filho_estrangeiro',
        'numero_rne',
        'orgao_emissor_rne',
        'data_validade_rne',
        'cep',
        'bairro',
        'id_uf',
        'endereco',
        'numero',
        'cidade',
        'complemento',
        'residente_exterior',
        'residencia_propria',
        'imovel_recurso_fgts',
        'pis',
        'data_cadastro_pis',
        'ctps',
        'data_expedicao_ctps',
        'id_uf_ctps',
    ];

    public function validate($data, $update = false)
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

    public function errors()
    {
        return $this->errors;
    }

    public function pessoa()
    {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

    public function deficiencias()
    {
        return $this->hasMany('App\FuncionarioDeficiencia', 'id_funcionario');
    }

    public function dependentes()
    {
        return $this->hasMany('App\FuncionarioDependente', 'id_funcionario');
    }

    public function contrato_trabalho()
    {
        return $this->hasMany('App\ContratoTrabalho', 'id_funcionario');
    }

    public function estado()
    {
        return $this->hasMany('App\Uf', 'id_uf');
    }

    public function pro_labore_formatado()
    {
        return number_format($this->pro_labore, 2, ',', '.');
    }

    public function setDataNascimentoAttribute($value)
    {
        $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setDataEmissaoRg($value)
    {
        $this->attributes['data_emissao_rg'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function save(array $options = [])
    {
        $usuario = Auth::user();
        try {
            Mail::send('emails.novo-funcionario', ['usuario' => $usuario->nome, 'empresa' => $this->pessoa->nome_fantasia, 'id_funcionario' => $this->id, 'funcionario' => $this->nome_completo], function ($m) use ($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Novo Funcionário Cadastrado');
            });
        } catch (\Exception $ex) {
            Log::critical($ex);
            throw $ex;
        }
        parent::save($options);
    }

}
