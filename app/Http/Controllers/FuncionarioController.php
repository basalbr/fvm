<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Funcionario;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class FuncionarioController extends Controller {

    public function index() {
        $empresas = \App\Pessoa::where('id_usuario', '=', Auth::user()->id)->orderBy('nome_fantasia')->get();
        return view('funcionarios.index', ['empresas' => $empresas]);
    }
public function index2($id) {
        $funcionarios = Funcionario::join('pessoa','pessoa.id','=','funcionario.id_pessoa')->where('funcionario.id_pessoa','=',$id)->where('pessoa.id_usuario', '=', Auth::user()->id)->orderBy('funcionario.nome_completo')->select('funcionario.*')->get();
        return view('funcionarios.index2', ['funcionarios' => $funcionarios]);
    }

    public function ler($id) {
        $noticia = Noticia::find($id);
        return view('noticias.ler', ['noticia' => $noticia]);
    }

      public function create() {
        $usuario = Auth::user();
        $dow = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
        $estados = \App\Uf::orderBy('nome', 'asc')->get();
//        $cargos = Cargo::orderBy('descricao', 'asc')->get();
        return view('funcionarios.cadastrar', ['usuario' => $usuario, 'dow' => $dow, 'estados'=>$estados]);
    }

    public function store(Request $request) {
        $data = Input::all();
        $rules = ['nome' => 'required', 'senha' => 'required|min:4|max:4', 'cpf' => 'required|min:14|max:14|unique:funcionario', 'pis' => 'required', 'ctps' => 'required', 'salario' => 'required', 'dsr' => 'required', 'horario' => 'required'];
        $niceNames = array(
            'nome' => 'Nome Completo',
            'senha' => 'Senha',
            'pis' => 'PIS',
            'ctps' => 'CTPS',
            'cpf' => 'CPF',
            'salario' => 'Salário',
            'horario' => 'Horário',
            'dsr' => 'D.S.R'
        );


        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);

        $validator->after(function($validator) {
            $dow = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
            $data = Input::all();
            $total_minutos = 0;
            foreach ($data['horario'] as $k => $hora) {
                if (isset($hora[0]) && isset($hora[1]) && !empty($hora[0]) && !empty($hora[1]) && $hora[0] != '' && $hora[1] != '') {
                    $hora1 = strtotime($hora[0]);
                    $hora2 = strtotime($hora[1]);
                    if ($hora2 <= $hora1) {
                        $validator->errors()->add('horario[' . $k . '][0]', $dow[$k] . ' - O horário de entrada do 1° turno deve ser menor que o horário de saída do 1° turno');
                    }
                    $total_minutos+=round(abs($hora2 - $hora1) / 60, 2);
                }
                if (isset($hora[2]) && isset($hora[3]) && !empty($hora[2]) && !empty($hora[3]) && $hora[2] != '' && $hora[3] != '') {
                    $hora1 = strtotime($hora[2]);
                    $hora2 = strtotime($hora[3]);
                    if ($hora2 <= $hora1) {
                        $validator->errors()->add('horario[' . $k . '][2]', $dow[$k] . ' - O horário de entrada do 2° turno deve ser menor que o horário de saída do 2° turno');
                    }
                    $total_minutos+=round(abs($hora2 - $hora1) / 60, 2);
                }
                if (isset($hora[1]) && isset($hora[2]) && !empty($hora[1]) && !empty($hora[2]) && $hora[1] != '' && $hora[2] != '') {
                    $hora1 = strtotime($hora[1]);
                    $hora2 = strtotime($hora[2]);
                    if ($hora2 <= $hora1) {
                        $validator->errors()->add('horario[' . $k . '][1]', $dow[$k] . ' - O horário de saída do 1° turno deve ser menor que o horário de entrada do 2° turno');
                    }
                }
                if ((isset($hora[0]) && !isset($hora[1])) || (isset($hora[1]) && !isset($hora[0])) || (!$hora[0] && $hora[1]) || (!$hora[1] && $hora[0])) {
                    $validator->errors()->add('horario[' . $k . '][0]', $dow[$k] . ' - É necessário preencher um horário de entrada e de saída no 1° turno');
                }
                if ((isset($hora[2]) && !isset($hora[3])) || (isset($hora[3]) && !isset($hora[2])) || (!$hora[2] && $hora[3]) || (!$hora[3] && $hora[2])) {
                    $validator->errors()->add('horario[' . $k . '][2]', $dow[$k] . ' - É necessário preencher um horário de entrada e de saída no 2° turno');
                }
            }
            if (($total_minutos) / 60 > 44) {
                $validator->errors()->add('horario[0][0]', 'Horário - O total de horas da jornada semanal não pode exceder 44 horas');
            }
        });
        if ($validator->fails()) {
            return redirect(route('funcionario-novo'))
                            ->withErrors($validator->errors()->all())
                            ->withInput();
        }

        $usuario = Auth::user();

        $funcionario = new Funcionario;

//        if (count($errors = $funcionario->validateInput($data, null))) {
//            return redirect(route('funcionario-novo'))
//                            ->withErrors($errors)
//                            ->withInput();
//        }

        $grupo_horario = new GrupoHorario;

        $funcionario->nome = $data['nome'];
        $funcionario->cpf = $data['cpf'];
        $funcionario->ctps = $data['ctps'];
        $funcionario->pis = $data['pis'];
        $funcionario->salario = str_replace(',', '.', str_replace('.', '', $data['salario']));
        $funcionario->senha = Hash::make($data['senha']);
        $funcionario->id_usuario = $usuario->id;
        $funcionario->save();

        $grupo_horario->dsr = $data['dsr'];
        $grupo_horario->id_funcionario = $funcionario->id;
        $grupo_horario->save();

        foreach ($data['horario'] as $dia => $hora) {
            $horario = new Horario;
            $horario->id_grupo_horario = $grupo_horario->id;
            $horario->hora1 = $hora[0] ? $hora[0] : null;
            $horario->hora2 = $hora[1] ? $hora[1] : null;
            $horario->hora3 = $hora[2] ? $hora[2] : null;
            $horario->hora4 = $hora[3] ? $hora[3] : null;
            $horario->dia = $dia;
            $horario->save();
        }

        return redirect(route('funcionarios'))->with('alertModal', ['message' => 'Funcionário cadastrado com sucesso!', 'title' => 'Sucesso!']);
    }

   public function edit($id) {
        $usuario = Auth::user();
        $dow = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
        $funcionario = Funcionario::where('id_usuario', '=', $usuario->id)->where('id', '=', $id)->first();
        $grupo_horario = GrupoHorario::where('id_funcionario', '=', $funcionario->id)->orderBy('updated_at', 'desc')->first();
        return view('funcionarios.editar', ['usuario' => $usuario, 'funcionario' => $funcionario, 'dow' => $dow, 'grupo_horario' => $grupo_horario]);
    }

    public function update($id) {
        $data = Input::all();
        $rules = ['nome' => 'required', 'senha' => 'min:4|max:4', 'cpf' => 'required|min:14|max:14|unique:funcionario,cpf,' . $id, 'pis' => 'required', 'ctps' => 'required', 'salario' => 'required', 'dsr' => 'required', 'horario' => 'required'];
        $niceNames = array(
            'nome' => 'Nome Completo',
            'senha' => 'Senha',
            'pis' => 'PIS',
            'ctps' => 'CTPS',
            'cpf' => 'CPF',
            'salario' => 'Salário',
            'horario' => 'Horário',
            'dsr' => 'D.S.R'
        );


        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($niceNames);

        $validator->after(function($validator) {
            $dow = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
            $data = Input::all();
            $total_minutos = 0;
            foreach ($data['horario'] as $k => $hora) {
                if (isset($hora[0]) && isset($hora[1]) && !empty($hora[0]) && !empty($hora[1]) && $hora[0] != '' && $hora[1] != '') {
                    $hora1 = strtotime($hora[0]);
                    $hora2 = strtotime($hora[1]);
                    if ($hora2 <= $hora1) {
                        $validator->errors()->add('horario[' . $k . '][0]', $dow[$k] . ' - O horário de entrada do 1° turno deve ser menor que o horário de saída do 1° turno');
                    }
                    $total_minutos+=round(abs($hora2 - $hora1) / 60, 2);
                }
                if (isset($hora[2]) && isset($hora[3]) && !empty($hora[2]) && !empty($hora[3]) && $hora[2] != '' && $hora[3] != '') {
                    $hora1 = strtotime($hora[2]);
                    $hora2 = strtotime($hora[3]);
                    if ($hora2 <= $hora1) {
                        $validator->errors()->add('horario[' . $k . '][2]', $dow[$k] . ' - O horário de entrada do 2° turno deve ser menor que o horário de saída do 2° turno');
                    }
                    $total_minutos+=round(abs($hora2 - $hora1) / 60, 2);
                }
                if (isset($hora[1]) && isset($hora[2]) && !empty($hora[1]) && !empty($hora[2]) && $hora[1] != '' && $hora[2] != '') {
                    $hora1 = strtotime($hora[1]);
                    $hora2 = strtotime($hora[2]);
                    if ($hora2 <= $hora1) {
                        $validator->errors()->add('horario[' . $k . '][1]', $dow[$k] . ' - O horário de saída do 1° turno deve ser menor que o horário de entrada do 2° turno');
                    }
                }
                if ((isset($hora[0]) && !isset($hora[1])) || (isset($hora[1]) && !isset($hora[0])) || (!$hora[0] && $hora[1]) || (!$hora[1] && $hora[0])) {
                    $validator->errors()->add('horario[' . $k . '][0]', $dow[$k] . ' - É necessário preencher um horário de entrada e de saída no 1° turno');
                }
                if ((isset($hora[2]) && !isset($hora[3])) || (isset($hora[3]) && !isset($hora[2])) || (!$hora[2] && $hora[3]) || (!$hora[3] && $hora[2])) {
                    $validator->errors()->add('horario[' . $k . '][2]', $dow[$k] . ' - É necessário preencher um horário de entrada e de saída no 2° turno');
                }
            }
            if (($total_minutos) / 60 > 44) {
                $validator->errors()->add('horario[0][0]', 'Horário - O total de horas da jornada semanal não pode exceder 44 horas');
            }
        });
        if ($validator->fails()) {
            return redirect(route('funcionario-editar', ['id' => $id]))
                            ->withErrors($validator->errors()->all())
                            ->withInput();
        }

        $usuario = Auth::user();
        $funcionario = Funcionario::where('id_usuario', '=', $usuario->id)->where('id', '=', $id)->first();

//        if (count($errors = $funcionario->validateInput($data, null))) {
//            return redirect(route('funcionario-novo'))
//                            ->withErrors($errors)
//                            ->withInput();
//        }

        $grupo_horario = new GrupoHorario;

        $funcionario->nome = $data['nome'];
        $funcionario->cpf = $data['cpf'];
        $funcionario->ctps = $data['ctps'];
        $funcionario->pis = $data['pis'];
        $funcionario->salario = str_replace(',', '.', str_replace('.', '', $data['salario']));
        if (isset($data['senha']) && !empty($data['senha'])) {
            $funcionario->senha = Hash::make($data['senha']);
        }
        $funcionario->save();

        $grupo_horario->dsr = $data['dsr'];
        $grupo_horario->id_funcionario = $funcionario->id;
        $grupo_horario->save();

        foreach ($data['horario'] as $dia => $hora) {
            $horario = new Horario;
            $horario->id_grupo_horario = $grupo_horario->id;
            $horario->hora1 = $hora[0] ? $hora[0] : null;
            $horario->hora2 = $hora[1] ? $hora[1] : null;
            $horario->hora3 = $hora[2] ? $hora[2] : null;
            $horario->hora4 = $hora[3] ? $hora[3] : null;
            $horario->dia = $dia;
            $horario->save();
        }

        return redirect(route('funcionarios'))->with('alertModal', ['message' => 'Funcionário alterado com sucesso!', 'title' => 'Sucesso!']);
    }

}
