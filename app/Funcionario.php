<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use App\Notificacao;

class Funcionario extends Model {

    use SoftDeletes;

    protected $rules = [
    ];
    protected $errors;
    protected $niceNames = [
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

    public function validate($data, $update = false) {
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

    public function pessoa() {
        return $this->belongsTo('App\Pessoa', 'id_pessoa');
    }

    public function deficiencias() {
        return $this->hasMany('App\FuncionarioDeficiencia', 'id_funcionario');
    }

    public function dependentes() {
        return $this->hasMany('App\FuncionarioDependente', 'id_funcionario');
    }

    public function contrato_trabalho() {
        return $this->hasMany('App\ContratoTrabalho', 'id_funcionario');
    }

    public function estado() {
        return $this->hasMany('App\Uf', 'id_uf');
    }

    public function pro_labore_formatado() {
        return number_format($this->pro_labore, 2, ',', '.');
    }

    public function save(array $options = []) {
        $usuario = Auth::user();
        try {
            \Illuminate\Support\Facades\Mail::send('emails.novo-funcionario', ['usuario' => $usuario->nome, 'empresa' => $this->nome_fantasia, 'id_funcionario' => $this->id, 'funcionario'=>$this->nome_completo], function ($m) use($usuario) {
                $m->from('site@webcontabilidade.com', 'WEBContabilidade');
                $m->to('admin@webcontabilidade.com')->subject('Novo Funcionário Cadastrado');
            });
        } catch (\Exception $ex) {
            return true;
        }
        parent::save($options);
    }

}
