@extends('layouts.dashboard')
@section('header_title', 'Funcionários')
@section('js')
@parent
<script type="text/javascript">
    $(document).ready(function () {
        $('#mostrar-dependente').on('click', function () {
            $('#dependente-modal').modal('show');
        });
        $('#lista-dependentes').on('click', '.remover-dependente', function () {

            var id = parseInt($(this).data('id'));
            $(this).parent().parent().remove();
            $('#dependentes input').each(function () {
                if (parseInt($(this).data('id')) == id) {
                    $(this).remove();
                }
            });
            if ($('#lista-dependentes tr').length == 1) {
                $('.nenhum-dependente').show();
            }
        });

        $('#adicionar-dependente').on('click', function (e) {
            $('#adicionar-dependente').text('Adicionar Dependente');
            var id = 0;
            var arrDependente = $('#dependente-form').serializeArray();
            $.post("{{route('ajax-validar-dependente')}}", arrDependente, function (data) {
                if (data.length) {
                    var html = '<ul>';
                    for (i in data) {
                        html += '<li>' + data[i] + '</li>';
                    }
                    html += '</ul>';
                    $('#dependente-erros').html(html);
                    $('#dependente-modal').animate({
                        scrollTop: $("#dependente-erros").offset().top
                    }, 1000);
                    $('#dependente-form .alert').show();
                    e.preventDefault();
                } else {
                    $('#dependente-form .alert').hide();
                    if ($('#dependente-form').data('id') >= 0) {
                        id = parseInt($('#dependente-form').data('id'));
                        $("#dependentes dependente[" + id + "]").remove();
                        $('#dependente-form').removeData('id');
                        $('#lista-dependentes .editar-dependente').each(function () {
                            if (parseInt($(this).data('id')) == id) {
                                $(this).parent().parent().remove();
                            }
                        });
                    } else {
                        $('#dependentes input').each(function () {
                            if (parseInt($(this).data('id')) >= id) {
                                id = parseInt($(this).data('id')) + 1;
                            }
                        });
                    }
                    var listaRow = '<tr>';
                    for (i in arrDependente) {

                        $('#dependentes').append('<input type="hidden" name="dependente[' + id + '][' + arrDependente[i].name + ']" value="' + arrDependente[i].value + '" data-id="' + id + '" />');
                        if (arrDependente[i].name == 'nome' || arrDependente[i].name == 'cpf') {
                            listaRow += "<td>" + arrDependente[i].value + "</td>";
                        }
                    }
                    listaRow += "<td><button type='button' class='btn btn-warning editar-dependente' data-id='" + id + "'><span class='fa fa-edit'></span> Editar</button> <button type='button' class='btn btn-danger remover-dependente' data-id='" + id + "'><span class='fa fa-remove'></span> Remover</button></td></tr>";
                    $('#lista-dependentes').append(listaRow);
                    $('.nenhum-dependente').hide();
                    $('#dependente-modal').modal('hide');
                    $('#dependente-modal form')[0].reset();
                }
            });
        });

        $('#lista-dependentes').on('click', '.editar-dependente', function () {
            var id = parseInt($(this).data('id'));
            $('#adicionar-dependente').text('Alterar Informações');
            $('#dependente-form').data('id', id);
            $('#dependentes input').each(function () {
                if (parseInt($(this).data('id')) == id) {
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    name = name.replace('dependente[' + id + '][', '');
                    name = name.replace(']', '');
                    $('#dependente-form input[name="' + name + '"]').val($(this).val());
                }
            });
            $('#dependente-modal').modal('show');
        }
        );
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

<div class='card'>
    <h1>Cadastrar Funcionário</h1>
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
                <input class="form-control" type="text" placeholder="Digite o nome completo do funcionário" name="nome_completo" value="{{ Input::old('nome_completo') }}" >

            </div>
            <div class="form-group">
                <label class="control-label">Nome da Mãe</label>
                <input class="form-control" type="text" placeholder="Digite o nome completo da mãe do funcionário" name="nome_mae" value="{{ Input::old('nome_mae') }}" >
            </div>
            <div class="form-group">
                <label class="control-label">Nome do Pai</label>
                <input class="form-control" type="text" placeholder="Digite o nome completo do pai do funcionário" name="nome_pai" value="{{ Input::old('nome_pai') }}" >
            </div>
            <div class="form-group">
                <label class="control-label">Nome do Cônjuge</label>
                <input class="form-control" type="text" placeholder="Digite o nome completo do cônjuge do funcionário" name="nome_conjuge" value="{{ Input::old('nome_conjuge') }}" >

            </div>
            <div class="form-group">
                <label class="control-label">Nacionalidade</label>
                <input class="form-control" type="text" placeholder="Nacionalidade do funcionário" name="nacionalidade" value="{{ Input::old('nacionalidade') }}">
            </div>


            <div class="form-group">
                <label class="control-label">Naturalidade</label>
                <input class="form-control" type="text" placeholder="Local de nascimento do funcionário" name="naturalidade" value="{{ Input::old('naturalidade') }}">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Grau de instrução</label>

                <select class="form-control" name="grau_instrucao" value="{{ Input::old('grau_instrucao') }}" >
                    <option value="Analfabeto">Analfabeto</option>
                    <option value="Ensino Fundamental até 5ª Incompleto">Ensino Fundamental até 5ª Incompleto</option>
                    <option value="Ensino Fundamental 5ª Completo">Ensino Fundamental 5ª Completo</option>
                    <option value="Ensino Fundamental 6ª ao 9ª">Ensino Fundamental 6ª ao 9ª</option>
                    <option value="Ensino Fundamental Completo">Ensino Fundamental Completo</option>
                    <option value="Ensino Médio Incompleto">Ensino Médio Incompleto</option>
                    <option value="Ensino Médio Completo" selected="selected">Ensino Médio Completo</option>
                    <option value="Superior Incompleto">Superior Incompleto</option>
                    <option value="Superior Completo">Superior Completo</option>
                    <option value="Pós-Graduação">Pós-Graduação</option>
                    <option value="Mestrado">Mestrado</option>
                    <option value="Doutorado">Doutorado</option>
                    <option value="Ph. D">Ph. D</option>
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">Grupo Sanguíneo</label>
                <select class="form-control" name="grupo_sanguineo" value="{{ Input::old('grupo_sanguineo') }}" >
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="Não informado" selected="selected">Não informado</option>
                </select>
            </div>
            <div class="form-group">

                <label class="control-label">Raça/Cor</label>
                <select class="form-control" name="raca_cor" value="{{ Input::old('raca_cor') }}" >
                    <option value="Indígena">Indígena</option>
                    <option value="Branca">Branca</option>
                    <option value="Preta">Preta</option>
                    <option value="Amarela">Amarela</option>
                    <option value="Parda">Parda</option>
                    <option value="Não Informada" selected="selected">Não Informada</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Sexo</label>
                <select class="form-control" name="sexo" value="{{ Input::old('sexo') }}" >
                    <option value="">Selecione uma opção</option>
                    <option value="F">Feminino</option>
                    <option value="M">Masculino</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Data de nascimento</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_nascimento" value="{{ Input::get('data_nascimento') }}" >

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
                <input class="form-control cpf-mask" type="text" placeholder="Digite o CPF do funcionário" name="cpf" value="{{ Input::old('cpf') }}" >

            </div>
            <div class="form-group">
                <label class="control-label">RG</label>
                <input class="form-control" type="text" placeholder="Número do RG" name="rg" value="{{ Input::old('rg') }}">

            </div>
            <div class="form-group">
                <label class="control-label">Órgão Expeditor RG com UF</label>
                <input class="form-control" type="text" placeholder="Órgão Expeditor do RG com UF. Exemplo: SSP/SC" name="orgao_expeditor_rg" value="{{ Input::old('orgao_expeditor_rg') }}">

            </div>
            <div class="form-group">
                <label class="control-label">Data de Emissão RG</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_emissao_rg" value="{{ Input::get('data_emissao_rg') }}" >

            </div>
            <div class="form-group">
                <label class="control-label">PIS</label>
                <input class="form-control" type="text" placeholder="Digite o PIS do funcionário" name="pis" value="{{ Input::old('pis') }}" >
            </div>
            <div class="form-group">
                <label class="control-label">Data de cadastro do PIS</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_cadastro_pis" value="{{ Input::get('data_cadastro_pis') }}" >
            </div>

            <div class="form-group">
                <label class="control-label">CTPS</label>
                <input class="form-control" type="text" placeholder="Digite o CTPS do funcionário" name="ctps" value="{{ Input::old('ctps') }}" >

            </div>
            <div class="form-group">
                <label class="control-label">Data de expedição da CTPS</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_expedicao_ctps" value="{{ Input::get('data_expedicao_ctps') }}" >

            </div>
            <div class="form-group">
                <label class="control-label">Estado de emissão do CTPS</label>
                <select class="form-control" name="id_uf_ctps" value="{{ Input::old('id_uf_ctps') }}">
                    <option value="">Selecione uma opção</option>
                    @foreach($estados as $estado)
                    <option value="{{$estado->id}}">{{$estado->nome}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Número do Título Eleitoral</label>
                <input class="form-control" type="text" placeholder="Número do Título Eleitoral" name="numero_titulo_eleitoral" value="{{ Input::old('numero_titulo_eleitoral') }}">

            </div>
            <div class="form-group">
                <label class="control-label">Zona e Seção Eleitoral</label>
                <input class="form-control" type="text" placeholder="Digite a Zona e a Seção Eleitoral. Exemplo: 36/42" name="zona_secao_eleitoral" value="{{ Input::old('zona_secao_eleitoral') }}">

            </div>
            <div class="form-group">
                <label class="control-label">Número da Carteira de Motorista</label>
                <input class="form-control" type="text" placeholder="Digite o número da carteira de motorista" name="numero_carteira_motorista" value="{{ Input::old('numero_carteira_motorista') }}">
            </div>
            <div class="form-group">
                <label class="control-label">Categoria da Carteira de Motorista</label>
                <input class="form-control" type="text" placeholder="Digite a categoria da carteira de motorista" name="categoria_carteira_motorista" value="{{ Input::old('categoria_carteira_motorista') }}">
            </div>
            <div class="form-group">
                <label class="control-label">Vencimento da Carteira de Motorista</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="vencimento_carteira_motorista" value="{{ Input::get('vencimento_carteira_motorista') }}" >
            </div>
            <div class="form-group">
                <label class="control-label">Número da Carteira de Reservista</label>
                <input class="form-control" type="text" placeholder="Digite o número da carteira de reservista" name="rg" value="{{ Input::old('numero_carteira_reservista') }}">
            </div>
            <div class="form-group">
                <label class="control-label">Categoria da Carteira de Reservista</label>
                <input class="form-control" type="text" placeholder="Digite a categoria da carteira de reservista" name="rg" value="{{ Input::old('vencimento_carteira_reservista') }}">
            </div>
        </div>
        <div class="clearfix"></div>
        <br />
        <h3 class="text-uppercase">Estrangeiro</h3>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Data de Chegada</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_chegada_estrangeiro" value="{{ Input::get('data_chegada_estrangeiro') }}" >
            </div>

            <div class="form-group">
                <label class="control-label">Condição de Trabalhador Estrangeiro no Brasil</label>
                <select class="form-control" name="condicao_trabalhador_estrangeiro" value="{{ Input::old('condicao_trabalhador_estrangeiro') }}">
                    <option value="" selected="">Não é estrangeiro</option>
                    <option value="Temporário">Temporário</option>
                    <option value="Permanente">Permanente</option>
                    <option value="Asilado">Asilado</option>
                    <option value="Refugiado">Refugiado</option>
                    <option value="Solicitante de Refúgio">Solicitante de Refúgio</option>
                    <option value="Residente em país fronteiriço ao Brasil">Residente em país fronteiriço ao Brasil</option>
                    <option value="Deficiente físico e com mais de 51 anos">Deficiente físico e com mais de 51 anos</option>
                    <option value="Com residência provisória e anistiado, em situação irregular">Com residência provisória e anistiado, em situação irregular</option>
                    <option value="Permanência no Brasil em razão de filhos ou cônjuge brasileiros">Permanência no Brasil em razão de filhos ou cônjuge brasileiros</option>
                    <option value="Beneficiado pelo acordo entre países do Mercosul">Beneficiado pelo acordo entre países do Mercosul</option>
                    <option value="Dependente de agente diplomático e/ou consular de países que mantém convênio de reciprocidade para o exercício de atividade remunerada no Brasil">Dependente de agente diplomático e/ou consular de países que mantém convênio de reciprocidade para o exercício de atividade remunerada no Brasil</option>
                    <option value="Beneficiado pelo Tratado de Amizade, Cooperação e Consulta entre a República Federativa do Brasil e a República Portuguesa">Beneficiado pelo Tratado de Amizade, Cooperação e Consulta entre a República Federativa do Brasil e a República Portuguesa</option>

                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Número do Processo MTE</label>
                <input class="form-control fone-mask" type="text" placeholder="Digite o número do processo MTE" name="numero_processo_mte" value="{{ Input::old('numero_processo_mte') }}">
            </div>
            <div class="form-group">
                <label class="control-label">Data de Validade da Carteira de Trabalho</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="validade_carteira_trabalho" value="{{ Input::get('validade_carteira_trabalho') }}" >
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="casado_estrangeiro" name="casado_estrangeiro"><span></span> Casado(a) com Brasileiro(a).
                </label>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="filho_estrangeiro" name="filho_estrangeiro"><span></span> Filho(s) com Brasileiro(a).
                </label>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Número do RNE</label>
                <input class="form-control fone-mask" type="text" placeholder="Digite o número do RNE" name="numero_rne" value="{{ Input::old('numero_rne') }}">
            </div>
            <div class="form-group">
                <label class="control-label">Data de Expedição do RNE</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_expedicao_rne" value="{{ Input::get('data_expedicao_rne') }}" >
            </div>
            <div class="form-group">
                <label class="control-label">Órgão Emissor do RNE</label>
                <input class="form-control fone-mask" type="text" placeholder="Digite o órgão emissor do RNE" name="orgao_emissor_rne" value="{{ Input::old('orgao_emissor_rne') }}">
            </div>
            <div class="form-group">
                <label class="control-label">Data de Validade do RNE</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_validade_rne" value="{{ Input::get('data_validade_rne') }}" >
            </div>
        </div>
        <div class="clearfix"></div>
        <br />
        <h3 class="text-uppercase">Deficiências</h3>
        <div class="col-md-4">
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="Motora" id="motora" name="deficiencia[motora]"><span></span> Motora.
                </label>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="Visual" id="visual" name="deficiencia[visual]"><span></span> Visual.
                </label>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="Auditiva" id="auditiva" name="deficiencia[auditiva]"><span></span> Auditiva.
                </label>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="Mental" id="mental" name="deficiencia[mental]"><span></span> Mental.
                </label>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="Reabilitado" id="reabilitado" name="deficiencia[reabilitado]"><span></span> Reabilitado.
                </label>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="Outras" id="outras" name="deficiencia[outras]"><span></span> Outras.
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
                <select class="form-control" name="id_uf" value="{{ Input::old('id_uf') }}">
                    <option value="">Selecione uma opção</option>
                    @foreach($estados as $estado)
                    <option value="{{$estado->id}}">{{$estado->nome}}</option>
                    @endforeach
                </select>

            </div>
            <div class="form-group">
                <label class="control-label">Cidade</label>
                <input class="form-control" type="text" placeholder="Digite a cidade onde o funcionário reside" name="cidade" value="{{ Input::old('cidade') }}">

            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="residente_exterior" name="residente_exterior"><span></span> Residente/Domiciliado no Exterior.
                </label>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" name="residencia_propria"><span></span> Residência Própria.
                </label>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="imovel_fgts" name="imovel_fgts"><span></span> Imóvel Adquirido com Recursos do FGTS.
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
                <input class="form-control" type="text" placeholder="Digite o endereço do funcionário" name="endereco" value="{{ Input::old('endereco') }}">

            </div>
            <div class="form-group">
                <label class="control-label">Número</label>
                <input class="form-control" type="text" placeholder="Digite o número do endereço" name="numero" value="{{ Input::old('numero') }}">

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
                <input class="form-control" type="text" placeholder="Digite o cargo do funcionário" name="cargo" value="{{ Input::old('cargo') }}" >
            </div>
            <div class="form-group">
                <label class="control-label">Função</label>
                <input class="form-control" type="text" placeholder="Digite a função do funcionário" name="funcao" value="{{ Input::old('funcao') }}" >
            </div>
            <div class="form-group">
                <label class="control-label">Departamento</label>
                <input class="form-control" type="text" placeholder="Digite o departamento do funcionário" name="departamento" value="{{ Input::old('departamento') }}" >
            </div>

            <div class="form-group">
                <label class="control-label">Categoria</label>
                <select class="form-control" name="categoria" value="{{ Input::old('categoria') }}">
                    <option value="Mensalista" selected="selected">Mensalista</option>
                    <option value="Semanalista">Semanalista</option>
                    <option value="Diarista">Diarista</option>
                    <option value="Horista">Horista</option>
                    <option value="Tarefeiro">Tarefeiro</option>
                    <option value="Comissionado">Comissionado</option>
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">Vínculo empregatício</label>
                <select class="form-control" name="vinculo_empregaticio" value="{{ Input::old('vinculo_empregaticio') }}">
                    <option value="Celetista" selected="selected">Celetista</option>
                    <option value="Trabalhador Avulso">Trabalhador Avulso</option>
                    <option value="Trabalhador Temporário Lei 6.019/74">Trabalhador Temporário Lei 6.019/74</option>
                    <option value="Celetista Contrato Prazo Determinado">Celetista Contrato Prazo Determinado</option>
                    <option value="Trabalhador Rural">Trabalhador Rural</option>
                    <option value="Trab. Rural Contrato Prazo Determinado">Trab. Rural Contrato Prazo Determinado</option>
                    <option value="Contrato Prazo Determinado Lei 9.601/98">Contrato Prazo Determinado Lei 9.601/98</option>
                    <option value="Empregado Doméstico - Regime Tempo Parcial">Empregado Doméstico - Regime Tempo Parcial</option>
                    <option value="Trabalhador Rural - Regime Tempo Parcial">Trabalhador Rural - Regime Tempo Parcial</option>
                    <option value="Celetista - Regime Tempo Parcial">Celetista - Regime Tempo Parcial</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Salário (R$)</label>
                <input class="form-control dinheiro-mask" type="text" placeholder="Digite o Salário, somente números" name="salario" value="{{ Input::old('salario') }}" >

            </div>


            <div class="form-group">
                <label class="control-label">Data de admissão</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_admissao" value="{{ Input::get('data_admissao') }}" >
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="banco_horas" name="possui_banco_horas"><span></span> O funcionário possui banco de horas.
                </label>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="descontar_vale_transporte" name="desconta_vale_transporte"><span></span> Desejo descontar o Vale Transporte do funcionário (6%).
                </label>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="experiencia" name="contrato_experiencia"><span></span> O contrato é de experiência.
                </label>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="professor" name="professor"><span></span> É professor.
                </label>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="primeiro_emprego" name="primeiro_emprego"><span></span> Primeiro emprego.
                </label>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="form-group">
                <label class="control-label">Situação do Seguro Desemprego</label>
                <select class="form-control" name="situacao_seguro_desemprego" value="{{ Input::old('situacao_seguro_desemprego') }}">
                    <option value="Nenhum requerimento encontrado">Nenhum requerimento encontrado</option>
                    <option value="Notificado - Parcela a Emitir">Notificado - Parcela a Emitir</option>
                    <option value="Notificado - Parcela Emitida">Notificado - Parcela Emitida</option>
                    <option value="Notificado - Seguro Completo">Notificado - Seguro Completo</option>
                    <option value="Notificado - Mais de XX anos da Data de Demissão/Suspensão">Notificado - Mais de XX anos da Data de Demissão/Suspensão</option>
                    <option value="Notificado - A restituir parcela ou parcelas">Notificado - A restituir parcela ou parcelas</option>
                    <option value="Notificado - Parcela não recebida">Notificado - Parcela não recebida</option>
                    <option value="Notificado - Reemprego">Notificado - Reemprego</option>
                    <option value="Notificado - Não tem 36 Contribuições/Postagens &gt; 120 dias">Notificado - Não tem 36 Contribuições/Postagens &gt; 120 dias</option>
                    <option value="Notificado - Não possui 06 salários consecutivos">Notificado - Não possui 06 salários consecutivos</option>
                    <option value="Notificado - Divergência nome/ nome da mãe/ CPF/ sexo/ data de nascimento">Notificado - Divergência nome/ nome da mãe/ CPF/ sexo/ data de nascimento</option>
                    <option value="Notificado - 19 meses - sem direito a saldo de parcelas">Notificado - 19 meses - sem direito a saldo de parcelas</option>
                    <option value="Notificado - Por indeferimento de recurso">Notificado - Por indeferimento de recurso</option>
                    <option value="Notificado - Percepção de renda própria">Notificado - Percepção de renda própria</option>
                    <option value="Recusa - Aguardando Retorno do Encaminhamento">Recusa - Aguardando Retorno do Encaminhamento</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Quantidade de Dias que recebe Vale Transporte</label>
                <input class="form-control" type="text" placeholder="Digite a quantidade de dias que o funcionário recebe vale transporte. Exemplo: 30" name="qtde_dias_vale_transporte" value="{{ Input::old('qtde_dias_vale_transporte') }}">

            </div>
            <div class="form-group">
                <label class="control-label">Valor de Vale Transporte</label>
                <input class="form-control  dinheiro-mask" type="text" placeholder="Digite o valor de Vale Transporte" name="valor_vale_transporte" value="{{ Input::old('valor_vale_transporte') }}">

            </div>
            <div class="form-group">
                <label class="control-label">Assistência Médica</label>
                <input class="form-control  dinheiro-mask" type="text" placeholder="Digite o valor de Assistência Médica" name="valor_assistencia_medica" value="{{ Input::old('valor_assistencia_medica') }}">

            </div>
            <div class="form-group">
                <label class="control-label">Desconto de Assistência Médica</label>
                <input class="form-control  dinheiro-mask" type="text" placeholder="Digite o valor de desconto da Assistência Médica" name="desconto_assistencia_medica" value="{{ Input::old('desconto_assistencia_medica') }}">

            </div>



        </div>
        <div class="clearfix"></div>
        <br/>
        <h3 class="text-uppercase">Sindicato</h3>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Nome do Sindicato</label>
                <input class="form-control" type="text" placeholder="Digite o nome do sindicato do funcionário" name="sindicato" value="{{ Input::old('sindicato') }}" >
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="pagou_contribuicao" name="pagou_contribuicao"><span></span> Pagou contribuição.
                </label>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="checkbox checkbox-styled radio-success">
                    <input type="checkbox" value="1" id="sindicalizado" name="sindicalizado"><span></span> Sindicalizado.
                </label>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class='col-md-12'>
            <div class="form-group">
                <label class="control-label">Competência</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="competencia_sindicato" value="{{ Input::get('competencia_sindicato') }}" >
            </div>
        </div>
        <div class="clearfix"></div>
        <br/>

        <h3 class="text-uppercase">Contrato de experiência</h3>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Quantidade de dias</label>
                <input class="form-control money-mask" type="text" placeholder="Informe a quantidade dias de experiência" name="qtde_dias_experiencia" value="{{ Input::old('qtde_dias_experiencia') }}">
            </div>
            <div class="form-group">
                <label class="control-label">Data de início</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_inicio_experiencia" value="{{ Input::get('data_inicio_experiencia') }}" >

            </div>
            <div class="form-group">
                <label class="control-label">Data final</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_final_experiencia" value="{{ Input::get('data_final_experiencia') }}" >

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Data início de prorrogação</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_inicio_prorrogacao_experiencia" value="{{ Input::get('data_inicio_prorrogacao_experiencia') }}" >

            </div>

            <div class="form-group">
                <label class="control-label">Data final de prorrogação</label>
                <input class="form-control date-mask" type="text" placeholder="--/--/--" name="data_final_prorrogacao_experiencia" value="{{ Input::get('data_final_prorrogacao_experiencia') }}" >

            </div>
        </div>
        <div class="clearfix"></div>
        <br />        
        <h3>Dependente</h3>
        <div class='col-xs-12'>
            <p>Clique em 'Adicionar novo dependente' para cadastrar um dependente.</p><p><b>Atenção:</b> Se o funcionário possuir dependentes é de suma importância informá-los no sistema.</p>
        </div>
        <div id='dependentes'></div>
        <div class='col-md-12'>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id='lista-dependentes'>
                    <tr>
                        <td colspan="3" class="nenhum-dependente">Por favor adicione pelo menos um Dependente.</td>
                    </tr>
                </tbody>
            </table> 
            <div class='form-group'>
                <button id="mostrar-dependente" type="button" class='btn btn-primary'><span class='fa fa-plus'></span> Adicionar novo dependente</button>
            </div>
        </div>
        <div class="clearfix"></div>
        <br />
        <h3>Horário de Trabalho</h3>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">D.S.R (Descanso semanal remunerado)</label>
                <select class="form-control"  id='dsr' name='dsr'>
                    @foreach($dow as $n => $dia)
                    <option value="{{$n}}" {{$n == 0 ? 'selected="selected"' : ''}}>{{$dia}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class='col-xs-12'>
            <p><b>Digite na tabela abaixo o horário de trabalho do funcionário de acordo com o dia da semana.</b></p>
        </div>
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
        <div class="clearfix"></div>
        <div class="form-group">
            <div class='col-md-12'>
                <button type="submit" class="btn btn-success"><span class='fa fa-user-plus'></span> Cadastrar funcionário</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
        <div class='clearfix'></div>
    </form>
    <br />
    <div class='clearfix'></div>
</div>
@stop
@section('modal')
<div class="modal fade" id="dependente-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"  style="width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Inserir Dependente</h4>
            </div>
            <div class="modal-body">
                <form id='dependente-form'>
                    <div class="alert alert-warning animate shake" style="display: none">
                        <b>Atenção</b><br />
                        <div id="dependente-erros"></div>
                    </div>
                    <div class='col-xs-12'>
                        <p>Complete os campos abaixo com as informações do <b>dependente.</b><br />
                    </div>
                    <div class='form-group'>
                        <label>Nome *</label>
                        <input type='text' class='form-control' name='nome' value="" />
                    </div> 
                    <div class='form-group'>
                        <label>Data de Nascimento *</label>
                        <input type='text' class='form-control date-mask' name='data_nascimento' value="" />
                    </div>
                    <div class='form-group'>
                        <label>Local de Nascimento *</label>
                        <input type='text' class='form-control' name='local_nascimento' value="" />
                    </div> 
                    <div class='form-group'>
                        <label>CPF</label>
                        <input type='text' class='form-control cpf-mask' name='cpf' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>RG *</label>
                        <input type='text' class='form-control' name='rg' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Órgão Expeditor do RG (Ex: SSP/SC) *</label>
                        <input type='text' class='form-control' name='orgao_rg' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Tipo de dependência *</label>
                        <select class="form-control" name='tipo_dependencia'>
                            <option value="Cônjuge ou companheiro(a) com o (a) qual tenha filho ou viva há mais de 5 anos">Cônjuge ou companheiro(a) com o (a) qual tenha filho ou viva há mais de 5 anos</option>
                            <option value="Filho(a) ou enteado(a) até 21 anos" selected="selected">Filho(a) ou enteado(a) até 21 anos</option>
                            <option value="Filho(a) ou enteando(a) universitário(a) ou cursando escola técnica de 2º grau, até 24 anos">Filho(a) ou enteando(a) universitário(a) ou cursando escola técnica de 2º grau, até 24 anos</option>
                            <option value="Filho(a) ou enteado(a) em qualquer idade, quando incapacitado física e/ou mentalmente para o trabalho">Filho(a) ou enteado(a) em qualquer idade, quando incapacitado física e/ou mentalmente para o trabalho</option>
                            <option value="Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do qual detenha guarda judicial, até 21 anos">Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do qual detenha guarda judicial, até 21 anos</option>
                            <option value="Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, com idade até 24 anos, se ainda estiver cursando estabelecimento de nível superior ou escola técnica de 2º grau, desde que tenha detido sua guarda judicial até os 21 anos">Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, com idade até 24 anos, se ainda estiver cursando estabelecimento de nível superior ou escola técnica de 2º grau, desde que tenha detido sua guarda judicial até os 21 anos</option>
                            <option value="Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha guarda judicial, em qualquer idade, quando incapacitado física e/ou mentalmente para o trabalho">Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha guarda judicial, em qualquer idade, quando incapacitado física e/ou mentalmente para o trabalho</option>
                            <option value="Pais, avós e bisavós">Pais, avós e bisavós</option>
                            <option value="Menor pobre, até 21 anos, que crie e eduque e do qual detenha guarda judicial">Menor pobre, até 21 anos, que crie e eduque e do qual detenha guarda judicial</option>
                            <option value="Pessoa absolutamente incapaz, da qual seja tutor ou curador">Pessoa absolutamente incapaz, da qual seja tutor ou curador</option>
                        </select> 
                    </div>
                    <div class='form-group'>
                        <label>Matrícula *</label>
                        <input type='text' class='form-control' name='matricula' value="" />
                    </div>
                    <div class='form-group'>
                        <label>Cartório *</label>
                        <input type='text' class='form-control' name='cartorio' value="" />
                    </div>
                    <div class='form-group'>
                        <label>Número de Registro do Cartório *</label>
                        <input type='text' class='form-control' name='numero_cartorio' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Número do Livro</label>
                        <input type='text' class='form-control' name='numero_livro' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Número da Folha</label>
                        <input type='text' class='form-control' name='numero_folha' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Número da D.N.V</label>
                        <input type='text' class='form-control' name='numero_dnv' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Data de Entrega do Documento *</label>
                        <input type='text' class='form-control' name='data_entrega_documento' value="" />
                    </div>

                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="adicionar-dependente">Adicionar Dependente</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@stop