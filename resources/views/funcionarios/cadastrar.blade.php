@extends('layouts.dashboard')
@section('header_title', 'Funcionários')
@section('js')
@parent
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
            var id = $(this).parent().parent().attr('id');

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
        });
    });
</script>
@stop
@section('main')
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
                    <input class="form-control" type="text" placeholder="Digite o nome completo do funcionário" name="nome" value="{{ Input::old('nome') }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">Nome da Mãe</label>
                    <input class="form-control" type="text" placeholder="Digite o nome completo da mãe do funcionário" name="nome_mae" value="{{ Input::old('nome_mae') }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">Nome do Cônjuge</label>
                    <input class="form-control" type="text" placeholder="Digite o nome completo da mãe do funcionário" name="nome_mae" value="{{ Input::old('nome_mae') }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">Nacionalidade</label>
                    <input class="form-control" type="text" placeholder="Nacionalidade do funcionário" name="nome_mae" value="{{ Input::old('nacionalidade') }}">
                </div>


                <div class="form-group">
                    <label class="control-label">Naturalidade</label>
                    <input class="form-control" type="text" placeholder="Local de nascimento do funcionário" name="nome_mae" value="{{ Input::old('naturalidade') }}">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Grau de instrução</label>
                    <select class="form-control" name="sexo" value="{{ Input::old('sexo') }}" required="">
                        <option value="">Selecione uma opção</option>
                        <option value="F">Feminino</option>
                        <option value="M">Masculino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Grupo Sanguíneo</label>
                    <select class="form-control" name="sexo" value="{{ Input::old('sexo') }}" required="">
                        <option value="">Selecione uma opção</option>
                        <option value="F">Feminino</option>
                        <option value="M">Masculino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Raça/Cor</label>
                    <select class="form-control" name="sexo" value="{{ Input::old('sexo') }}" required="">
                        <option value="">Selecione uma opção</option>
                        <option value="F">Feminino</option>
                        <option value="M">Masculino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Sexo</label>
                    <select class="form-control" name="sexo" value="{{ Input::old('sexo') }}" required="">
                        <option value="">Selecione uma opção</option>
                        <option value="F">Feminino</option>
                        <option value="M">Masculino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Data de nascimento</label>
                    <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_nascimento" value="{{ Input::get('data_nascimento') }}" required="">

                </div>
            </div>

            <div class="col-md-6">


            </div>
            <div class="clearfix"></div>
            <br />
            <h3>documentos</h3>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">CPF</label>
                    <input class="form-control cpf-mask" type="text" placeholder="Digite o CPF do funcionário" name="cpf" value="{{ Input::old('cpf') }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">RG</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Órgão Expeditor RG com UF</label>
                    <input class="form-control" type="text" placeholder="Órgão Expeditor do RG" name="rg_orgao" value="{{ Input::old('rg_orgao') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Data de Emissão RG</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">PIS</label>
                    <input class="form-control" type="text" placeholder="Digite o PIS do funcionário" name="pis" value="{{ Input::old('pis') }}" required="">
                </div>
                <div class="form-group">
                    <label class="control-label">Data de cadastro do PIS</label>
                    <input class="form-control" type="text" placeholder="Digite o PIS do funcionário" name="pis" value="{{ Input::old('pis') }}" required="">
                </div>

                <div class="form-group">
                    <label class="control-label">CTPS</label>
                    <input class="form-control" type="text" placeholder="Digite o CTPS do funcionário" name="ctps" value="{{ Input::old('ctps') }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">Data de expedição da CTPS</label>
                    <input class="form-control" type="text" placeholder="Digite o CTPS do funcionário" name="ctps" value="{{ Input::old('ctps') }}" required="">

                </div>
                <div class="form-group">
                    <label class="control-label">Estado de emissão do CTPS</label>
                    <select class="form-control" name="ctps_uf" value="{{ Input::old('ctps_uf') }}">
                        <option value="">Selecione uma opção</option>
                        @foreach($estados as $estado)
                        <option value="{{$estado->sigla}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Número do Título Eleitoral</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Zona e Seção Eleitoral</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Número da Carteira de Motorista</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Categoria da Carteira de Motorista</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Vencimento da Carteira de Motorista</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Número da Carteira de Reservista</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Categoria da Carteira de Reservista</label>
                    <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">
                </div>
            </div>
            <div class="clearfix"></div>
            <br />
            <h3 class="text-uppercase">Estrangeiro</h3>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Data de Chegada</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número de telefone" name="telefone" value="{{ Input::old('telefone') }}">
                </div>

                <div class="form-group">
                    <label class="control-label">Condição de Trabalhador Estrangeiro no Brasil</label>
                    <select class="form-control" name="estado" value="{{ Input::old('estado') }}">
                        <option value="">Selecione uma opção</option>
                        @foreach($estados as $estado)
                        <option value="{{$estado->sigla}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Número do Processo MTE</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número de telefone" name="telefone" value="{{ Input::old('telefone') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Data de Validade da Carteira de Trabalho</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número de telefone" name="telefone" value="{{ Input::old('telefone') }}">
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Casado(a) com Brasileiro(a).
                    </label>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Filho(s) com Brasileiro(a).
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Número do RNE</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número de telefone" name="telefone" value="{{ Input::old('telefone') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Data de Expedição do RNE</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número de telefone" name="telefone" value="{{ Input::old('telefone') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Órgão Emissor do RNE</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número de telefone" name="telefone" value="{{ Input::old('telefone') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Data de Validade do RNE</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número de telefone" name="telefone" value="{{ Input::old('telefone') }}">
                </div>
            </div>
            <div class="clearfix"></div>
            <br />
            <h3 class="text-uppercase">Deficiências</h3>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Motora.
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Visual.
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Auditiva.
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Mental.
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Reabilitado.
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Outras.
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <br />
            <h3 class="text-uppercase">Endereço / Contato</h3>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">E-mail</label>
                    <input class="form-control" type="text" placeholder="Digite o e-mail" name="email" value="{{ Input::old('email') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Telefone</label>
                    <input class="form-control fone-mask" type="text" placeholder="Número de telefone" name="telefone" value="{{ Input::old('telefone') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">CEP</label>
                    <input class="form-control cep-mask" type="text" placeholder="99999-999" name="cep" value="{{ Input::old('cep') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Estado</label>
                    <select class="form-control" name="estado" value="{{ Input::old('estado') }}">
                        <option value="">Selecione uma opção</option>
                        @foreach($estados as $estado)
                        <option value="{{$estado->sigla}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label class="control-label">Cidade</label>
                    <input class="form-control" type="text" placeholder="Digite a cidade onde o funcionário reside" name="cidade" value="{{ Input::old('cidade') }}">

                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Residente/Domiciliado no Exterior.
                    </label>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Residência Própria.
                    </label>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Imóvel Adquirido com Recursos do FGTS.
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Bairro</label>
                    <input class="form-control" type="text" placeholder="Digite o bairro do funcionário" name="bairro" value="{{ Input::old('bairro') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Endereço</label>
                    <input class="form-control" type="text" placeholder="Digite o endereço completo do funcionário" name="endereco" value="{{ Input::old('endereco') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Número</label>
                    <input class="form-control" type="text" placeholder="Digite o complemento do endereço" name="complemento" value="{{ Input::old('complemento') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Complemento</label>
                    <input class="form-control" type="text" placeholder="Digite o complemento do endereço" name="complemento" value="{{ Input::old('complemento') }}">

                </div>

            </div>
            <div class="clearfix"></div>
            <br/>
            <h3 class="text-uppercase">Contrato de Trabalho</h3>

            <div class="col-md-6">

                <div class="form-group">
                    <label class="control-label">Cargo</label>
                    <input class="form-control" type="text" placeholder="Digite o CTPS do funcionário" name="ctps" value="{{ Input::old('ctps') }}" required="">
                </div>
                <div class="form-group">
                    <label class="control-label">Função</label>
                    <input class="form-control" type="text" placeholder="Digite o CTPS do funcionário" name="ctps" value="{{ Input::old('ctps') }}" required="">
                </div>
                <div class="form-group">
                    <label class="control-label">Departamento</label>
                    <input class="form-control" type="text" placeholder="Digite o CTPS do funcionário" name="ctps" value="{{ Input::old('ctps') }}" required="">
                </div>
                <div class="form-group">
                    <label class="control-label">Categoria</label>
                    <select class="form-control" name="ctps_uf" value="{{ Input::old('ctps_uf') }}">
                        <option value="">Selecione uma opção</option>
                        @foreach($estados as $estado)
                        <option value="{{$estado->sigla}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Vínculo empregatício</label>
                    <select class="form-control" name="ctps_uf" value="{{ Input::old('ctps_uf') }}">
                        <option value="">Selecione uma opção</option>
                        @foreach($estados as $estado)
                        <option value="{{$estado->sigla}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Salário (R$)</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o Salário, somente números" name="salario" value="{{ Input::old('salario') }}" required="">

                </div>


                <div class="form-group">
                    <label class="control-label">Data de admissão</label>
                    <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_admissao" value="{{ Input::get('data_admissao') }}" required="">
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
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> O contrato é de experiência.
                    </label>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> É professor.
                    </label>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Primeiro emprego.
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Situação do Seguro Desemprego</label>
                    <select class="form-control" name="ctps_uf" value="{{ Input::old('ctps_uf') }}">
                        <option value="">Selecione uma opção</option>
                        @foreach($estados as $estado)
                        <option value="{{$estado->sigla}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Quantidade de Dias que recebe Vale Transporte</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de Vale Transporte" name="vale_tranporte" value="{{ Input::old('vale_tranporte') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Valor de Vale Transporte</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de Vale Transporte" name="vale_tranporte" value="{{ Input::old('vale_tranporte') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Assistência Médica</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de Assistência Médica" name="assistencia_medica" value="{{ Input::old('assistencia_medica') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Desconto de Assistência Médica</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de desconto da Assistência Médica" name="desconto_assistencia_medica" value="{{ Input::old('desconto_assistencia_medica') }}">

                </div>



            </div>
            <div class="clearfix"></div>
            <br/>
            <h3 class="text-uppercase">Sindicato</h3>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Nome do Sindicato</label>
                    <input class="form-control" type="text" placeholder="Digite o CTPS do funcionário" name="ctps" value="{{ Input::old('ctps') }}" required="">
                </div>
                <div class="form-group">
                    <label class="checkbox checkbox-styled radio-success">
                        <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Pagou contribuição.
                    </label>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="checkbox checkbox-styled radio-success">
                            <input type="checkbox" value="true" id="experiencia" name="experiencia"><span></span> Sindicalizado.
                        </label>
                        <div class="clearfix"></div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label">Competência</label>
                    <input class="form-control" type="text" placeholder="Digite o CTPS do funcionário" name="ctps" value="{{ Input::old('ctps') }}" required="">
                </div>

            </div>
            <div class="clearfix"></div>
            <br/>

            <h3 class="text-uppercase">Contrato de experiência</h3>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Quantidade de dias</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de INSS" name="inss" value="{{ Input::old('inss') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Data de início</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de Vale Transporte" name="vale_tranporte" value="{{ Input::old('vale_tranporte') }}">

                </div>
                <div class="form-group">
                    <label class="control-label">Data final</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de Assistência Médica" name="assistencia_medica" value="{{ Input::old('assistencia_medica') }}">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Data início de prorrogação</label>
                    <input class="form-control money-mask" type="text" placeholder="Digite o valor de desconto da Assistência Médica" name="desconto_assistencia_medica" value="{{ Input::old('desconto_assistencia_medica') }}">

                </div>

                <div class="form-group">
                    <label class="control-label">Data final de prorrogação</label>
                    <input class="form-control" type="text" placeholder="Digite a quantidade de dependentes que o funcionário possui" name="dependentes" value="{{ Input::old('dependentes') }}">

                </div>
            </div>
            <div class="clearfix"></div>
            <br />        
            <h3>Horário de Trabalho</h3>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">D.S.R (Descanso semanal remunerado)</label>
                    <select class="form-control" required="" id='dsr' name='dsr'>
                        @foreach($dow as $n => $dia)
                        <option value="{{$n}}" {{$n == 0 ? 'selected="selected"' : ''}}>{{$dia}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <p><b>Digite na tabela abaixo o horário de trabalho do funcionário de acordo com o dia da semana.</b></p>
            <div class="col-md-12">
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
                            <input class="form-control time-mask" type="text" placeholder="--:--" name="horario[{{$n}}][0]" value="{{ isset(Input::old('horario')[$n][0]) ? Input::old('horario')[$n][0] : '' }}">
                        </td>
                        <td class="text-center horario">
                            <input class="form-control time-mask" type="text" placeholder="--:--" name="horario[{{$n}}][1]" value="{{  isset(Input::old('horario')[$n][1]) ? Input::old('horario')[$n][1] : '' }}">
                        </td>
                        <td class="text-center horario">
                            <input class="form-control time-mask" type="text" placeholder="--:--" name="horario[{{$n}}][2]" value="{{  isset(Input::old('horario')[$n][2]) ? Input::old('horario')[$n][2] : '' }}">
                        </td>
                        <td class="text-center horario">
                            <input class="form-control time-mask" type="text" placeholder="--:--" name="horario[{{$n}}][3]" value="{{  isset(Input::old('horario')[$n][3]) ? Input::old('horario')[$n][3] : '' }}">
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <b>00:00</b>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><span class='fa fa-save'></span> Cadastrar funcionário</button>
                <a href="{{URL::previous()}}" class="btn btn-default"><span class='fa fa-history'></span> Voltar</a>
            </div>
            <div class='clearfix'></div>
        </form>
        
        <div class='clearfix'></div>
    </div>
</div>
@stop