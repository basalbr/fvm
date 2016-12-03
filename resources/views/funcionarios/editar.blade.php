@extends('layouts.dashboard')
@section('js')
@parent()
<script type="text/javascript">
    $(document).ready(function () {

        $("#" + $("#dsr").val() + " input").attr('disabled', 'disabled');
        $("#" + $("#dsr").val() + " td:nth-child(6) b").text('D.S.R');

        function msToTime(s) {
            function addZ(n) {
                return (n < 10 ? '0' : '') + n;
            }
            var ms = s % 1000;
            s = (s - ms) / 1000;
            var secs = s % 60;
            s = (s - secs) / 60;
            var mins = s % 60;
            var hrs = (s - mins) / 60;
            if (!isNaN(addZ(hrs)) && !isNaN(addZ(mins))) {
                return addZ(hrs) + ':' + addZ(mins);
            }
        }

        function calculaHoras(obj) {
            var id = obj.parent().parent().attr('id');

            var horario1 = $("#" + id + " td:nth-child(2) input").val().split(":");
            var horario2 = $("#" + id + " td:nth-child(3) input").val().split(":");
            var horario3 = $("#" + id + " td:nth-child(4) input").val().split(":");
            var horario4 = $("#" + id + " td:nth-child(5) input").val().split(":");
            var data1 = new Date(2015, 1, 1, horario1[0], horario1[1]);
            var data2 = new Date(2015, 1, 1, horario2[0], horario2[1]);
            var data3 = new Date(2015, 1, 1, horario3[0], horario3[1]);
            var data4 = new Date(2015, 1, 1, horario4[0], horario4[1]);

            var resultado1 = false;
            var resultado2 = false;
            var resultadoFinal = "00:00";

            if (data1 > 0 && data2 > 0 && (data1 < data2)) {
                resultado1 = data2 - data1;
            }
            if (data3 > 0 && data4 && (data3 < data4)) {
                resultado2 = data4 - data3;
            }

            if (resultado1 > 0 && resultado2 > 0 && (data2 < data3)) {
                resultadoFinal = resultado1 + resultado2;
            }

            if (!resultado1 && resultado2 > 0) {
                resultadoFinal = resultado2;
            }

            if (resultado1 > 0 && !resultado2) {
                resultadoFinal = resultado1;
            }
            if (msToTime(resultadoFinal)) {
                $("#" + id + " td:nth-child(6) b").html(msToTime(resultadoFinal));
            }
        }

        $("#dsr").on('change', function () {
            $("td input").each(function () {
                if ($(this).attr('disabled')) {
                    $(this).removeAttr('disabled');
                    var id = $(this).parent().parent().attr('id');
                    $("#" + id + " td:nth-child(6) b").html('00:00');
                }
            })
            $("#" + $("#dsr").val() + " input").val('').attr('disabled', 'disabled');
            $("#" + $("#dsr").val() + " td:nth-child(6) b").text('D.S.R');
        });

        $(".horario input").on('blur', function () {
            calculaHoras($(this));
        });

        $(".horario input").each(function () {
            calculaHoras($(this));
        });

    });
</script>
@stop
@section('main-content')
<h1>Cadastrar Funcionário</h1>
<hr class="dash-title">
<div class='col-xs-12'>
    <div class='card'>
        @if($errors->has())
        <div class="alert alert-warning shake">
            <b>Atenção</b><br />
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
        </div>
        @endif
        <form class="form" method="POST" action="">
            @if(Session::has('success'))
            <div class="alert alert-success shake">
                {{ Session::get('success') }}
            </div>
            @endif

            @if($errors->has())
            <div class="alert alert-warning shake">
                <b>Atenção</b><br />
                @foreach ($errors->all() as $error)
                {{ $error }}<br />
                @endforeach
            </div>
            @endif

            <input type="text" style="display: none" />
            <input type="password" style="display: none" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h3 class="text-uppercase">Informações Pessoais</h3>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Nome Completo</label>
                    <input class="form-control" type="text" placeholder="Digite o nome completo do funcionário" name="nome" value="{{ $funcionario->nome }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">Nome da Mãe</label>
                    <input class="form-control" type="text" placeholder="Digite o nome completo da mãe do funcionário" name="nome_mae" value="{{ $funcionario->nome_mae }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">Nacionalidade</label>
                    <input class="form-control" type="text" placeholder="Nacionalidade do funcionário" name="nome_mae" value="{{ $funcionario->nacionalidade }}">
                </div>


                <div class="form-group">
                    <label class="control-label">Naturalidade</label>
                    <input class="form-control" type="text" placeholder="Local de nascimento do funcionário" name="nome_mae" value="{{ $funcionario->naturalidade }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Sexo</label>
                    <select class="form-control" name="sexo" value="{{ $funcionario->sexo }}" required="">
                        <option value="">Selecione uma opção</option>
                        <option value="F">Feminino</option>
                        <option value="M">Masculino</option>
                    </select>

                </div>
                <div class="form-group">
                    <label class="control-label">Data de nascimento</label>
                    <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_nascimento" value="{{ $funcionario->data_nascimento }}" required="">

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">CPF</label>
                    <input class="form-control cpf-mask" type="text" placeholder="Digite o CPF do funcionário" name="cpf" value="{{ $funcionario->cpf }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">RG</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ $funcionario->rg }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Órgão Expeditor</label>
                    <input class="form-control" type="text" placeholder="Órgão Expeditor do RG" name="rg_orgao" value="{{ $funcionario->rg_orgao }}">

                </div>
                <div class="form-group">
                    <label class="control-label">E-mail</label>
                    <input class="form-control" type="text" placeholder="Digite o e-mail" name="email" value="{{ $funcionario->email }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Telefone</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número de telefone" name="telefone" value="{{ $funcionario->telefone}}">

                </div>
                <div class="form-group">
                    <label class="control-label">Celular</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número do celular" name="celular" value="{{ $funcionario->celular }}">

                </div>

            </div>
            <div class="clearfix"></div>
            <br />
            <h3 class="text-uppercase">Endereço</h3>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">CEP</label>
                    <input class="form-control cep-mask" type="text" placeholder="99999-999" name="cep" value="{{ $funcionario->cep }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Estado</label>
                    <select class="form-control" name="estado">
                        <option value="">Selecione uma opção</option>
                        @foreach($estados as $estado)
                        <option value="{{$estado->id}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label class="control-label">Cidade</label>
                    <input class="form-control" type="text" placeholder="Digite a cidade onde o funcionário reside" name="cidade" value="{{ $funcionario->cidade }}">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Bairro</label>
                    <input class="form-control" type="text" placeholder="Digite o bairro do funcionário" name="bairro" value="{{ $funcionario->bairro }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Endereço</label>
                    <input class="form-control" type="text" placeholder="Digite o endereço completo do funcionário" name="endereco" value="{{ $funcionario->endereco }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Complemento</label>
                    <input class="form-control" type="text" placeholder="Digite o complemento do endereço" name="complemento" value="{{ $funcionario->complemento }}">

                </div>
            </div>
            <div class="clearfix"></div>
            <br/>
            <h3 class="text-uppercase">Informações Trabalhistas</h3>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">PIS</label>
                    <input class="form-control" type="text" placeholder="Digite o PIS do funcionário" name="pis" value="{{ $funcionario->pis }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">CTPS</label>
                    <input class="form-control" type="text" placeholder="Digite o CTPS do funcionário" name="ctps" value="{{ $funcionario->ctps }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">Estado de emissão do CTPS</label>
                    <select class="form-control" name="ctps_uf">
                        <option value="">Selecione uma opção</option>
                        @foreach($estados as $estado)
                        <option value="{{$estado->sigla}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label class="control-label">Salário (R$)</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o Salário, somente números" name="salario" value="{{ $funcionario->salario }}" required="">

                </div>


                <div class="form-group">
                    <label class="control-label">Data de admissão</label>
                    <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_admissao" value="{{ $funcionario->data_admissao }}" required="">

                </div>

                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="banco_horas" name="banco_horas"><span></span> O funcionário possui banco de horas.
                    </label>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="descontar_vale_transporte" name="descontar_vale_transporte"><span></span> Desejo descontar o Vale Transporte do funcionário (6%).
                    </label>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="descontar_inss" name="descontar_inss"><span></span> Desejo descontar o INSS do funcionário.
                    </label>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="adicional_noturno" name="adicional_noturno"><span></span> O funcionário possui adicional noturno.
                    </label>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> O contrato é de experiência.
                    </label>
                    <div class="clearfix"></div>
                </div>


            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">INSS</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de INSS" name="inss" value="{{ $funcionario->inss }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Vale Transporte</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de Vale Transporte" name="vale_tranporte" value="{{ $funcionario->vale_transporte }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Assistência Médica</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de Assistência Médica" name="assistencia_medica" value="{{ $funcionario->assistencia_medica }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Desconto de Assistência Médica</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de desconto da Assistência Médica" name="desconto_assistencia_medica" value="{{ $funcionario->desconto_assistencia_medica}}">

                </div>

                <div class="form-group">
                    <label class="control-label">Quantidade de Dependentes</label>
                    <input class="form-control" type="text" placeholder="Digite a quantidade de dependentes que o funcionário possui" name="dependentes" value="{{ $funcionario->dependentes }}">

                </div>

            </div>
            <div class="clearfix"></div>
            <br />        
            <h3 >Horário de Trabalho</h3>
            <div class="form-group">
                <select class="form-control" required="" id='dsr' name='dsr'>
                    @foreach($dow as $n => $dia)
                    <option value="{{$n}}" {{$n == $grupo_horario->dsr ? 'selected="selected"' : ''}}>{{$dia}}</option>
                    @endforeach
                </select>
                <label class="control-label">D.S.R (Descanso semanal remunerado)</label>
            </div>
            <br />
            <p class="text-primary">Digite na tabela abaixo o horário de trabalho do funcionário de acordo com o dia da semana.</p>
            <table class='table table-hover table-bordered table-striped'>
                <thead>
                    <tr>
                        <th></th>
                        <th colspan="2" class="bg-primary">1° TURNO</th>
                        <th colspan="2" class="bg-primary">2° TURNO</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style=" min-width: 78px;">Dia</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                        <th>Total de horas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dow as $n => $dia)

                    <tr id="{{$n}}">
                        <td style="vertical-align: middle; min-width: 78px;"><b>{{$dia}}</b></td>
                        <td class="text-center horario">
                            <input class="form-control time-mask" type="text" placeholder="--:--" name="horario[{{$n}}][0]" value="{{isset(Input::old('horario')[$n][0]) ? Input::old('horario')[$n][0] : $grupo_horario->horarios()->where('dia','=',$n)->first()['hora1']}}">
                        </td>
                        <td class="text-center horario">
                            <input class="form-control time-mask" type="text" placeholder="--:--" name="horario[{{$n}}][1]" value="{{isset(Input::old('horario')[$n][0]) ? Input::old('horario')[$n][0] : $grupo_horario->horarios()->where('dia','=',$n)->first()['hora2']}}">
                        </td>
                        <td class="text-center horario">
                            <input class="form-control time-mask" type="text" placeholder="--:--" name="horario[{{$n}}][2]" value="{{isset(Input::old('horario')[$n][0]) ? Input::old('horario')[$n][0] : $grupo_horario->horarios()->where('dia','=',$n)->first()['hora3']}}">
                        </td>
                        <td class="text-center horario">
                            <input class="form-control time-mask" type="text" placeholder="--:--" name="horario[{{$n}}][3]" value="{{isset(Input::old('horario')[$n][0]) ? Input::old('horario')[$n][0] : $grupo_horario->horarios()->where('dia','=',$n)->first()['hora4']}}">
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <b>00:00</b>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><span class='fa fa-save'></span> Salvar alterações</button>
                <a href="{{URL::previous()}}" class="btn btn-default"><span class='fa fa-history'></span> Voltar</a>
            </div>
            <div class='clearfix'></div>
        </form>
        <div class='clearfix'></div>
    </div>
</div>
@stop