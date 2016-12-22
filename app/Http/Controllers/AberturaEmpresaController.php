<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Processo;
use App\AberturaEmpresa;
use Illuminate\Support\Facades\Input;

class AberturaEmpresaController extends Controller {

    public function index() {
        $empresas = \App\AberturaEmpresa::where('id_usuario', '=', Auth::user()->id)->orderBy('nome_empresarial1')->get();
        return view('abertura_empresa.index', ['empresas' => $empresas]);
    }

    public function indexAdmin() {
        $empresas = AberturaEmpresa::query();
        $empresas->join('usuario', 'usuario.id', '=', 'abertura_empresa.id_usuario');
        $empresas->join('pagamento', 'pagamento.id_abertura_empresa', '=', 'abertura_empresa.id');

        if (Input::get('usuario')) {
            $empresas->where('usuario.nome', 'like', '%' . Input::get('usuario') . '%');
        }
        if (Input::get('nome_preferencial')) {
            $empresas->where('abertura_empresa.nome_empresarial1', 'like', '%' . Input::get('nome_preferencial') . '%');
        }
        if (Input::get('status_processo')) {
            $empresas->where('abertura_empresa.status', '=',Input::get('status_processo'));
        }
        if (Input::get('status_pagamento')) {
            $empresas->where('pagamento.status', '=',Input::get('status_pagamento'));
        }
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'usuario_asc') {
                $empresas->orderBy('usuario.nome', 'asc');
            }
            if (Input::get('ordenar') == 'usuario_asc') {
                $empresas->orderBy('usuario.nome', 'desc');
            }
            if (Input::get('ordenar') == 'status_pagamento') {
                $empresas->orderBy('pagamento.status', 'asc');
            }
            if (Input::get('ordenar') == 'status_processo') {
                $empresas->orderBy('abertura_empresa.status', 'asc');
            }
            if (Input::get('ordenar') == 'nome_preferencial_asc') {
                $empresas->orderBy('abertura_empresa.nome_empresarial1', 'asc');
            }
            if (Input::get('ordenar') == 'nome_preferencial_desc') {
                $empresas->orderBy('abertura_empresa.nome_empresarial1', 'desc');
            }
        } else {
            $empresas->orderBy('abertura_empresa.updated_at', 'desc');
        }
        $empresas = $empresas->select('abertura_empresa.*')->paginate(5);
        return view('admin.abertura_empresa.index', ['empresas' => $empresas]);
    }

    public function create() {
        $tipoTributacoes = \App\TipoTributacao::orderBy('descricao', 'asc')->get();
        $naturezasJuridicas = \App\NaturezaJuridica::orderBy('descricao', 'asc')->get();
        return view('abertura_empresa.cadastrar', [ 'tipoTributacoes' => $tipoTributacoes, 'naturezasJuridicas' => $naturezasJuridicas]);
    }

    public function remove($id) {
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->where('id_usuario', '=', Auth::user()->id)->first();
        $empresa->status = 'Cancelado';
        $empresa->save();
        return redirect(route('abertura-empresa'));
    }

    public function removeAdmin($id) {
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->first();
        $empresa->delete();
        return redirect(route('abertura-empresa-admin'));
    }

    public function store(Request $request) {
        $empresa = new \App\AberturaEmpresa;
        $request->merge(['id_usuario' => Auth::user()->id]);
        if (count($request->get('cnaes'))) {
            foreach ($request->get('cnaes') as $cnae) {
                if (\App\Cnae::where('id', '=', $cnae)->first()->id_tabela_simples_nacional == null) {
                    return redirect(route('cadastrar-abertura-empresa'))->withInput()->withErrors(['Não foi possível cadastrar sua empresa pois um de seus CNAEs não está apto para o Simples Nacional.\nNesse momento só trabalhamos com Simples Nacional.']);
                }
            }
        }
        if (!count($request->get('socio'))) {
            return redirect(route('cadastrar-abertura-empresa'))->withInput()->withErrors(['É necessário cadastrar pelo menos um sócio']);
        }
        $request->merge([
            'id_tipo_tributacao' => 1,
            'status_pagamento' => 'Aguardando pagamento',
            'status' => 'Novo'
        ]);
        if ($empresa->validate($request->all())) {
            $empresa = $empresa->create($request->all());
            if (count($request->get('socio'))) {
                foreach ($request->get('socio') as $obj) {
                    $socio = new \App\AberturaEmpresaSocio;
                    $obj['id_abertura_empresa'] = $empresa->id;
                    $old_date = explode('/', $obj['data_nascimento']);
                    $new_date = $old_date[2] . '-' . $old_date[1] . '-' . $old_date[0];
                    $obj['data_nascimento'] = $new_date;
                    if ($socio->validate($obj)) {
                        $socio = $socio->create($obj);
                    } else {
                        \App\AberturaEmpresa::find($empresa->id)->delete();
                        return redirect(route('cadastrar-abertura-empresa'))->withInput()->withErrors($socio->errors());
                    }
                }
            }
            if (count($request->get('cnaes'))) {
                foreach ($request->get('cnaes') as $cnae) {
                    $pessoaCnae = new \App\AberturaEmpresaCnae;
                    $pessoaCnae->id_abertura_empresa = $empresa->id;
                    $pessoaCnae->id_cnae = $cnae;
                    $pessoaCnae->save();
                }
            }
            $pagamento = new \App\Pagamento;
            $pagamento->tipo = 'abertura_empresa';
            $pagamento->id_abertura_empresa = $empresa->id;
            $pagamento->valor = 59;
            $pagamento->status = 'Pendente';
            $pagamento->vencimento = date('Y-m-d H:i:s', strtotime("+7 day"));
            $pagamento->save();

            $empresa->enviar_notificacao_criacao();

            return redirect(route('abertura-empresa'));
        } else {
            return redirect(route('cadastrar-abertura-empresa'))->withInput()->withErrors($empresa->errors());
        }
    }

    public function storeAdmin($id, Request $request) {
//        dd($request->all());
        $empresa = new \App\Pessoa;
        if (count($request->get('cnaes'))) {
            foreach ($request->get('cnaes') as $cnae) {
                if (\App\Cnae::where('id', '=', $cnae)->first()->id_tabela_simples_nacional == null) {
                    return redirect(route('cadastrar-abertura-empresa-admin', [$id]))->withInput()->withErrors(['Não foi possível cadastrar sua empresa pois um de seus CNAEs não está apto para o Simples Nacional.\nNesse momento só trabalhamos com Simples Nacional.']);
                }
            }
        }
        if (!count($request->get('socio'))) {
            return redirect(route('cadastrar-abertura-empresa-admin', [$id]))->withInput()->withErrors(['É necessário cadastrar pelo menos um sócio']);
        }
        //atencao, arrumar telefone!!!!!!!!!!!!!!!!!!!!
        $request->merge([
            'id_tipo_tributacao' => 1
        ]);
        if ($empresa->validate($request->all())) {
            $empresa = $empresa->create($request->all());
            if (count($request->get('socio'))) {
                foreach ($request->get('socio') as $obj) {
                    $socio = new \App\Socio;
                    $obj['id_pessoa'] = $empresa->id;
                    if ($socio->validate($obj)) {
                        $socio = $socio->create($obj);
                    } else {
                        \App\Socio::where('id_pessoa', '=', $empresa->id)->delete();
                        \App\Pessoa::find($empresa->id)->delete();
                        return redirect(route('cadastrar-abertura-empresa-admin', [$id]))->withInput()->withErrors($socio->errors());
                    }
                }
            }
            if (count($request->get('cnaes'))) {
                foreach ($request->get('cnaes') as $cnae) {
                    $pessoaCnae = new \App\PessoaCnae;
                    $pessoaCnae->id_pessoa = $empresa->id;
                    $pessoaCnae->id_cnae = $cnae;
                    $pessoaCnae->save();
                }
            }
            $abertura_empresa = \App\AberturaEmpresa::find($id);
            $abertura_empresa->status = 'Concluído';
            $abertura_empresa->enviar_notificacao_conclusao($request->get('nome_fantasia'));
            $abertura_empresa->save();

            $empresa->enviar_notificacao_nova_empresa();
            $empresa->abrir_processos();
            $empresa->criar_mensalidade($request);

            return redirect(route('empresas-admin'));
        } else {
            return redirect(route('cadastrar-abertura-empresa-admin', [$id]))->withInput()->withErrors($empresa->errors());
        }
    }

    public function edit($id) {
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->where('id_usuario', '=', Auth::user()->id)->first();
        return view('abertura_empresa.editar', ['empresa' => $empresa]);
    }

    public function editAdmin($id) {
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->first();
        return view('admin.abertura_empresa.editar', ['empresa' => $empresa]);
    }

    public function createAdmin($id) {
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->first();
        return view('admin.abertura_empresa.cadastrar', ['empresa' => $empresa]);
    }

    public function update($id, Request $request) {
        $mensagem = new \App\AberturaEmpresaComentario;
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->where('id_usuario')->first();
        if ($mensagem->validate($request->all())) {
            if ($request->file('anexo')) {
                $anexo = date('dmyhis') . '.' . $request->file('anexo')->guessClientExtension();
                $request->file('anexo')->move(getcwd() . '/uploads/abertura_empresa/', $anexo);
                $request->merge(['anexo' => $anexo]);
                $mensagem->anexo = $anexo;
            }
            $mensagem->mensagem = $request->get('mensagem');
            $mensagem->id_abertura_empresa = $id;
            $mensagem->id_usuario = Auth::user()->id;
            $mensagem->save();
            $empresa->enviar_notificacao_nova_mensagem_admin();
            return redirect(route('editar-abertura-empresa', [$id]));
        }
        return redirect(route('editar-abertura-empresa', [$id]))->withInput()->withErrors($mensagem->errors());
    }

    public function updateAdmin($id, Request $request) {
        $mensagem = new \App\AberturaEmpresaComentario;
        $empresa = \App\AberturaEmpresa::where('id', '=', $id)->first();
        if ($mensagem->validate($request->all())) {
            if ($request->file('anexo')) {
                $anexo = date('dmyhis') . '.' . $request->file('anexo')->guessClientExtension();
                $request->file('anexo')->move(getcwd() . '/uploads/abertura_empresa/', $anexo);
                $request->merge(['anexo' => $anexo]);
                $mensagem->anexo = $anexo;
            }

            $empresa->status = $request->get('status');
            $empresa->save();
            $mensagem->mensagem = $request->get('mensagem');
            $mensagem->id_abertura_empresa = $id;
            $mensagem->id_usuario = Auth::user()->id;
            $mensagem->save();
            $empresa->enviar_notificacao_nova_mensagem_usuario();
            return redirect(route('editar-abertura-empresa-admin', [$id]));
        }
        return redirect(route('editar-abertura-empresa-admin', [$id]))->withInput()->withErrors($mensagem->errors());
    }

    public function register() {
        return view('register.index');
    }

    public function checkEmail(Request $request) {
        $usuario = \App\Usuario::where('email', '=', $request->input('email'))->first();
        if ($usuario instanceof \App\Usuario) {
            return redirect(route('login'))->with('email', $request->input('email'));
        } else {
            return redirect(route('registrar'));
        }
    }

    public function validateSocio(Request $request) {
        $socio = new \App\AberturaEmpresaSocio;
        if ($request->get('data_nascimento')) {
            $old_date = explode('/', $request->get('data_nascimento'));
            $new_date = $old_date[2] . '-' . $old_date[1] . '-' . $old_date[0];
            $request->merge(['data_nascimento' => $new_date]);
        }
        if (!$socio->validate($request->all())) {
            return $socio->errors();
        }
    }

    public function validateSocioEmpresa(Request $request) {
        $request->merge(['id_pessoa' => 1]);
        $socio = new \App\Socio;
        if (!$socio->validate($request->all())) {
            return $socio->errors();
        }
    }

    public function validateAberturaEmpresa(Request $request) {
        $empresa = new \App\AberturaEmpresa;
        if (!$empresa->validate($request->all())) {
            if (!$request->get('socio')) {
                return array_merge($empresa->errors(), ['É necessário incluir ao menos um sócio']);
            }
            return $empresa->errors();
        }
    }

}
