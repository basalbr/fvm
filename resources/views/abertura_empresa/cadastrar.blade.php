@extends('layouts.dashboard')
@section('header_title', 'Solicitar abertura de empresa')
@section('js')
@parent
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type='text/javascript'>
var planos;
var max_documentos;
var max_contabeis;
var max_pro_labores;
var maxValor;
var minValor;
$(function () {
    $('.date-mask').on('keypress', function () {
        return false;
    });
    $('.date-mask').datepicker({
        language: 'pt-BR',
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    $('#mostrar-socio').on('click', function () {
        $('#socio-modal').modal('show');
    });
    $('#lista-socios').on('click', '.remover-socio', function () {

        var id = parseInt($(this).data('id'));
        $(this).parent().parent().remove();
        $('#socios input').each(function () {
            if (parseInt($(this).data('id')) == id) {
                $(this).remove();
            }
        });
        if ($('#lista-socios tr').length == 1) {
            $('.nenhum-socio').show();
        }
    });

    $('#adicionar-socio').on('click', function (e) {
        $('#adicionar-socio').text('Adicionar Sócio');
        var id = 0;
        var arrSocio = $('#socio-form').serializeArray();
        $.post("{{route('ajax-validar-socio')}}", arrSocio, function (data) {
            if (data.length) {
                var html = '<ul>';
                for (i in data) {
                    html += '<li>' + data[i] + '</li>';
                }
                html += '</ul>';
                $('#socio-erros').html(html);
                $('#socio-modal').animate({
                    scrollTop: $("#socio-erros").offset().top
                }, 1000);
                $('#socio-form .alert').show();
                e.preventDefault();
            } else {

                $('#socio-form .alert').hide();
                if ($(this).data('id')) {
                    id = parseInt($(this).data('id'));
                    $("#socios socio['" + id + "']").remove();
                    $(this).removeData('id');
                    $('#lista-socios .editar-socio').each(function () {
                        if (parseInt($(this).data('id')) == id) {
                            $(this).parent().parent().remove();
                        }
                    });
                } else {
                    $('#socios input').each(function () {
                        if (parseInt($(this).data('id')) >= id) {
                            id = parseInt($(this).data('id')) + 1;
                        }
                    });
                }
                var listaRow = '<tr>';
                for (i in arrSocio) {
                    $('#socios').append('<input type="hidden" name="socio[' + id + ']' + arrSocio[i].name + '" value="' + arrSocio[i].value + '" data-id="' + id + '" />');
                    if (arrSocio[i].name == 'nome' || arrSocio[i].name == 'cpf') {
                        listaRow += "<td>" + arrSocio[i].value + "</td>";
                    }
                }
                listaRow += "<td><button type='button' class='btn btn-warning editar-socio' data-id='" + id + "'><span class='fa fa-edit'></span> Editar</button> <button type='button' class='btn btn-danger remover-socio' data-id='" + id + "'><span class='fa fa-remove'></span> Remover</button></td></tr>";
                $('#lista-socios').append(listaRow);
                $('.nenhum-socio').hide();
                $('#socio-modal').modal('hide');
                $('#socio-modal form')[0].reset();
            }
        });
    });
    $('#lista-socios').on('click', '.editar-socio', function () {
        var id = parseInt($(this).data('id'));
        $('#adicionar-socio').text('Alterar Informações');
        $('#socio-form').data('id', id);
        $('#socios input').each(function () {
            if (parseInt($(this).data('id')) == id) {
                if ($(this).attr('name') != 'principal') {
                    $('#socio-form input[name="' + $(this).attr('name') + '"]').val($(this).val());
                } else {
                    if ($(this).val() == '1') {
                        $('#principal-sim').prop('checked', true);
                        $('#principal-nao').prop('checked', false);
                    } else {
                        $('#principal-sim').prop('checked', false);
                        $('#principal-nao').prop('checked', true);
                    }
                }
            }
        });
        $('#socio-modal').modal('show');
    }
    );

    $('#total_documentos, #contabilidade, #total_contabeis, #pro_labores').on('keyup', function () {

        var pro_labores = $('#pro_labores').val();
        var total_documentos = $('#total_documentos').val();
        var total_contabeis = $('#total_contabeis').val();
        minValor = maxValor;
        if (pro_labores > max_pro_labores) {
            $('#pro_labores').val(max_pro_labores);
        }
        if (total_documentos > max_documentos) {
            $('#total_documentos').val(max_documentos);
        }
        if (total_contabeis > max_contabeis) {
            $('#total_contabeis').val(max_contabeis);
        }
        if (!pro_labores) {
            $('#pro_labores').val(0);
        }
        if (!total_documentos) {
            $('#total_documentos').val(0);
        }
        if (!total_contabeis) {
            $('#total_contabeis').val(0);
        }
        for (i in planos) {

            if (total_contabeis <= parseInt(planos[i].total_documentos_contabeis) && total_documentos <= parseInt(planos[i].total_documentos) && pro_labores <= parseInt(planos[i].pro_labores) && parseFloat(planos[i].valor) < minValor) {
                minValor = parseFloat(planos[i].valor);
            }
        }
        $('#mensalidade').text('R$' + parseFloat(minValor).toFixed(2));
        contabilidade = $('#contabilidade').val().replace(".", "");
        contabilidade = parseFloat(contabilidade.replace(",", "."));
        totalDesconto = (contabilidade * 12) - (minValor * 12) > 0 ? (contabilidade * 12) - (minValor * 12) : 0;
        $('#economia').html('R$' + totalDesconto.toFixed(2));
    });

    $('.cnae-search').on('keyup', function () {
        $("#adicionar-cnae").prop('disabled', true);
        if ($(this).val().length == 9) {
            $.post("{{route('ajax-cnae')}}", {tipo: 'codigo', search: $(this).val()}, function (data) {
                var html = '';
                try {
                    $('.cnae-search-box .result').empty();
                    if (data.length) {
                        for (i in data) {
                            html += '<div class="cnae-item" data-descricao="' + data[i].descricao + '" data-val="' + data[i].codigo + '" data-id="' + data[i].id + '">';
                            html += '<b>Nome: ' + data[i].descricao + '</b><br />Código: ' + ' ' + data[i].codigo;
                            html += '</div>';
                        }
                        $('.cnae-search-box .result').html(html);
                        $('.cnae-search-box').show();
                        $("#adicionar-cnae").prop('disabled', false);
                    } else {
                        $('.cnae-search-box .result').empty();
                        $('.cnae-search-box').hide();
                    }
                } catch (e) {
                    $('.cnae-search-box').hide();
                }
            });
        } else {
            $('.cnae-search-box .result').empty();
            $('.cnae-search-box').hide();
        }
    });
    $("#adicionar-cnae").on('click', function () {
        var descricao = $('.cnae-search-box .result .cnae-item').data('descricao');
        var codigo = $('.cnae-search-box .result .cnae-item').data('val');
        var id = $('.cnae-search-box .result .cnae-item').data('id');
        $(".cnae-search").val(null);
        $('.cnae-search-box .result').empty();
        $('.cnae-search-box').hide();
        $("#lista-cnaes").append("<tr><td>" + descricao + "</td><td>" + codigo + "</td><td><button type='button' class='btn btn-danger remover-cnae' data-id='" + id + "'><span class='fa fa-remove'></span> Remover</button></td></tr>")
        $("#principal-form").append('<input type="hidden" value="' + id + '" name="cnaes[]"></input>');
        $('.nenhum-cnae').hide();
    });
    $("#lista-cnaes").on('click', '.remover-cnae', function () {
        var id = parseInt($(this).data('id'));
        $(this).parent().parent().remove();
        $('input[name="cnaes[]"]').each(function () {
            if (parseInt($(this).val()) == id) {
                $(this).remove();
            }
        });
        if ($('#lista-cnaes tr').length == 1) {
            $('.nenhum-cnae').show();
        }
    });
    $('.cnae-search-box .result').on('click', '.cnae-item', function () {
        $('.cnae-search').after('<input type="hidden" value="' + $(this).data('id') + '" name="cnaes[]"/>');
        $('.cnae-search').after('<div class="col-xs-12"><a data-id="' + $(this).data('id') + '" class="remove-cnae">' + $(this).data('val') + '</a></div>');
        $('.cnae-search').val('');
        $('.cnae-search-box .result').empty();
        $('.cnae-search-box').hide();
    });
    $("#abrir-modal-cnae").on('click', function () {
        $("#cnae-modal").modal('show');
    });
    $("#cnae-search").on('keyup', function () {

        if ($(this).val().length > 0) {
            $(this).parent().parent().find('button').prop("disabled", false);
        } else {
            $(this).parent().parent().find('button').prop("disabled", true);
        }
    });
    $("#cnae-form").on('submit', function (e) {
        e.preventDefault();
        $.post("{{route('ajax-cnae')}}", {tipo: 'descricao', search: $("#cnae-search").val()}, function (data) {
            $("#lista-cnaes-modal tr").not('.nenhum-cnae-modal').remove();
            if (data.length > 0) {
                var html;
                for (i in data) {
                    var jaExiste = false;
                    $('input[name="cnaes[]"]').each(function () {
                        if (parseInt($(this).val()) == data[i].id) {
                            jaExiste = true;
                        }
                    });
                    if (jaExiste) {
                        html += "<tr><td>" + data[i].descricao + "</td><td>" + data[i].codigo + "</td><td class='text-right'><button data-id='" + data[i].id + "' data-codigo='" + data[i].codigo + "' data-descricao='" + data[i].descricao + "' class='btn btn-success' disabled='disabled'> Adicionado</button></td></tr>";
                    } else {
                        html += "<tr><td>" + data[i].descricao + "</td><td>" + data[i].codigo + "</td><td class='text-right'><button data-id='" + data[i].id + "' data-codigo='" + data[i].codigo + "' data-descricao='" + data[i].descricao + "' class='btn btn-success'><span class='fa fa-plus'></span> Adicionar</button></td></tr>";
                    }
                }
                $(".nenhum-cnae-modal").hide();
                $("#lista-cnaes-modal").append(html);
            } else {
                $(".nenhum-cnae-modal").show();
            }
        });
    });
    $("#lista-cnaes-modal").on('click', 'button', function () {
        var descricao = $(this).data('descricao');
        var codigo = $(this).data('codigo');
        var id = $(this).data('id');
        $("#lista-cnaes").append("<tr><td>" + descricao + "</td><td>" + codigo + "</td><td><button type='button' class='btn btn-danger remover-cnae' data-id='" + id + "'><span class='fa fa-remove'></span> Remover</button></td></tr>")
        $("#principal-form").append('<input type="hidden" value="' + id + '" name="cnaes[]"/>');
        $('.nenhum-cnae').hide();
        $(this).prop('disabled', true);
        $(this).html('Adicionado');
    });
    $('#mostrar-simulador').on('click', function (e) {
        e.preventDefault();
        $('#mensalidade-modal').modal('show');
    });
    $('#cadastrar-empresa').on('click', function (e) {
        e.preventDefault();
        $('#total_documentos, #contabilidade, #total_contabeis, #pro_labores').clone().appendTo('#principal-form');
        $('#principal-form').submit();
    });
    $('[data-toggle="tooltip"]').tooltip()
});
</script>
@stop
@section('main')
<h1>Solicitar abertura de empresa</h1>
<hr class="dash-title">
<div class='col-xs-12'>
    <div class='card'>
        @if($errors->has())
        <div class="alert alert-warning animate shake">
            <b>Atenção</b><br />
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
        </div>
        @endif
        <form method="POST" action="" id="principal-form">
            <h3>Informações</h3>
            <p>Preencha os campos abaixo e clique em "enviar solicitação" para que possamos dar início ao processo de abertura de empresa.Se precisarmos de mais alguma informação entraremos diretamente em contato com você.</p>
            <p>Campos com * são obrigatórios.</p>
            {{ csrf_field() }}
            <input type="hidden" value="J" name='tipo' />
            <p>É necessário que você nos forneça 3 possíveis nomes para sua empresa para que possamos fazer uma análise de viabilidade.</p>
            <div class='form-group'>
                <label>Nome Empresarial Preferencial *</label>
                <input type='text' class='form-control' name='nome_empresarial1' value="{{Input::old('nome_empresarial1')}}" required=""/>
            </div>
            <div class='form-group'>
                <label>Nome Empresarial Alternativo 1 *</label>
                <input type='text' class='form-control' name='nome_empresarial2' value="{{Input::old('nome_empresarial2')}}" required=""/>
            </div>
            <div class='form-group'>
                <label>Nome Empresarial Alternativo 2 *</label>
                <input type='text' class='form-control' name='nome_empresarial3' value="{{Input::old('nome_empresarial3')}}" required=""/>
            </div>
            <div class='form-group'>
                <label>Natureza Jurídica *</label>
                <select class="form-control" name="id_natureza_juridica">
                    <option value="">Selecione uma opção</option>
                    @foreach($naturezasJuridicas as $natureza_juridica)
                    <option value="{{$natureza_juridica->id}}" {{Input::old('id_natureza_juridica') == $natureza_juridica->id ? 'selected' : ''}}>{{$natureza_juridica->descricao}}</option>
                    @endforeach
                </select>
            </div>
            <div class='form-group'>
                <label>Enquadramento da empresa *</label>
                <select class="form-control" name="enquadramento">
                    <option value="me" {{Input::old('enquadramento') == 'me' ? 'selected' : ''}}>ME</option>
                    <option value="epp" {{Input::old('enquadramento') == 'epp' ? 'selected' : ''}}>EPP</option>
                    <option value="normal" {{Input::old('enquadramento') == 'normal' ? 'selected' : ''}}>Normal</option>
                </select>
            </div>
            <div class='form-group'>
                <label>Capital Social * <span data-trigger="hover" class="text-info" title="Capital Social é o valor, a integralizar ou integralizado, correspondente à contra-partida do titular, sócios ou acionistas de um empreendimento, para o início ou a manutenção dos negócios. Para fins de registro do comércio, deverá constar, no documento de constituição empresarial, o montante da subscrição, e como sera feita a conferência do valor: em moeda corrente, bens ou direitos." data-toggle="tooltip" data-placement="top">(o que é isso?)</span></label>
                <p>Descreva o capital social da empresa</p>
                <textarea class='form-control' name='capital_social'>{{Input::old('capital_social')}}</textarea>
            </div>
            <h3>Endereço</h3>
            <p>Complete os campos abaixo com o endereço da sua empresa.</p>
            <div class='form-group'>
                <label>CEP *</label>
                <input type='text' class='form-control cep-mask' name='cep' value="{{Input::old('cep')}}" />
            </div>
            <div class='form-group'>
                <label>Estado *</label>
                <select class="form-control" name='id_uf'>
                    <option value="24">Santa Catarina</option>
                </select> 
            </div>
            <div class='form-group'>
                <label>Cidade *</label>
                <input type='text' class='form-control' name='cidade'  value="{{Input::old('cidade')}}"/>
            </div>
            <div class='form-group'>
                <label>Endereço *</label>
                <input type='text' class='form-control' name='endereco'  value="{{Input::old('endereco')}}"/>
            </div>
            <div class='form-group'>
                <label>Bairro *</label>
                <input type='text' class='form-control' name='bairro'  value="{{Input::old('bairro')}}"/>
            </div>
            <div class='form-group'>
                <label>Número *</label>
                <input type='text' class='form-control numero-mask' name='numero' value="{{Input::old('numero')}}"/>
            </div>
            <div class='form-group'>
                <label>Complemento</label>
                <input type='text' class='form-control' name='complemento'  value="{{Input::old('complemento')}}"/>
            </div>
            <div class='form-group'>
                <label>Inscrição IPTU *</label>
                <input type='text' class='form-control' name='iptu'  value="{{Input::old('iptu')}}"/>
            </div>
            <div class='form-group'>
                <label>Área total ocupada em m² *</label>
                <input type='text' class='form-control' name='area_ocupada'  value="{{Input::old('area_ocupada')}}"/>
            </div>
            <div class='form-group'>
                <label>Área total do imóvel m² *</label>
                <input type='text' class='form-control' name='area_total'  value="{{Input::old('area_total')}}"/>
            </div>
            <div class='form-group'>
                <label>CPF ou CNPJ do proprietário do imóvel *</label>
                <input type='text' class='form-control' name='cpf_cnpj_proprietario' value="{{Input::old('cpf_cnpj_proprietario')}}"/>
            </div>
            <h3>Sócios</h3>
            <p>Clique em 'Adicionar novo sócio' para cadastrar um sócio.</p><p><b>Atenção:</b> É necessário ter pelo menos um sócio cadastrado.</p>
            <div id='socios'></div>
            <div class='form-group'>
                <button id="mostrar-socio" type="button" class='btn btn-primary'>Adicionar novo sócio</button>
            </div>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id='lista-socios'>
                    <tr>
                        <td colspan="3" class="nenhum-socio">Por favor adicione pelo menos um Sócio.</td>
                    </tr>
                </tbody>
            </table> 
            <h3>CNAEs</h3>
            <p>Adicione os CNAEs relacionados à sua empresa. Caso não saiba os códigos, clique em Pesquisar CNAE.</p>
            <p><b>Atenção:</b> não adicione nenhum CNAE caso você não saiba quais CNAEs você deseja ou se precisa de ajuda.</p>
            <div class='form-group'>
                <label>CNAE</label>
                <div class='input-group col-md-6'>
                    <input type='text' class='form-control cnae-search cnae-mask'/>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success" id='adicionar-cnae' disabled="disabled"><span class="fa fa-plus"></span> Adicionar</button>
                    </span>
                </div>
                <br />
                <button type="button" class="btn btn-info" id='abrir-modal-cnae'><span class="fa fa-search"></span> Pesquisar CNAE</button>
                <div class="cnae-search-box"><div class="result"></div></div>
            </div>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Código</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id='lista-cnaes'>
                    <tr>
                        <td colspan="3" class="nenhum-cnae">Nenhum CNAE adicionado.</td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label>Caso tenha dúvida na escolha de seu CNAE, digite no campo abaixo a descrição detalhada da(s) atividade(s) que pretende realizar em sua empresa e retornaremos com a lista dos possíveis CNAE's.</label>
                <textarea class="form-control" name="cnae_duvida"></textarea>
            </div>
            <div class='form-group'>
                <a href="" class='btn btn-success'>Enviar solicitação</a>
            </div>
        </form>
        <div class='clearfix'></div>
    </div>
</div>
@stop
@section('modal')
<div class="modal fade" id="socio-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"  style="width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Inserir Sócio</h4>
            </div>
            <div class="modal-body">
                <form id='socio-form'>
                    <div class="alert alert-warning animate shake" style="display: none">
                        <b>Atenção</b><br />
                        <div id="socio-erros"></div>
                    </div>
                    <p>Complete os campos abaixo com as informações do <b>sócio.</b><br />

                    <div class='form-group'>
                        <label>Nome *</label>
                        <input type='text' class='form-control' name='nome' value="" />
                    </div> 
                    <div class='form-group'>
                        <label>Nome da mãe *</label>
                        <input type='text' class='form-control' name='nome_mae' value="" />
                    </div> 
                    <div class='form-group'>
                        <label>Nome do pai *</label>
                        <input type='text' class='form-control' name='nome_pai' value="" />
                    </div> 
                    <div class='form-group'>
                        <label>Data de Nascimento *</label>
                        <input type='text' class='form-control date-mask' name='data_nascimento' value="" />
                    </div>
                    <div class='form-group'>
                        <label>Estado Civil *</label>
                        <select class="form-control" name='estado_civil'>
                            <option value="">Selecione uma opção</option>
                            <option value="solteiro">Solteiro</option>
                            <option value="casado">Casado</option>
                            <option value="divorciado">Divorciado</option>
                            <option value="separado">Separado</option>
                            <option value="viuvo">Viúvo</option>
                        </select> 
                    </div>
                    <div class='form-group'>
                        <label>Regime de casamento *</label>
                        <select class="form-control" name='regime_casamento'>
                            <option value="">Selecione uma opção</option>
                            <option value="parcial">Separação Parcial dos Bens</option>
                            <option value="total">Separação Total dos Bens</option>
                            <option value="universal">Separação Universal dos Bens</option>
                        </select> 
                    </div>

                    <div class='form-group'>
                        <label>Email *</label>
                        <input type='text' class='form-control' name='email' value="" />
                    </div>
                    <div class='form-group'>
                        <label>Telefone *</label>
                        <input type='text' class='form-control fone-mask' name='telefone' value="" />
                    </div>

                    <div class='form-group'>
                        <label>CPF *</label>
                        <input type='text' class='form-control cpf-mask' name='cpf' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>RG *</label>
                        <input type='text' class='form-control' name='rg' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Órgão Expedidor do RG (Ex: SSP/SC) *</label>
                        <input type='text' class='form-control' name='orgao_expedidor' value=""/>
                    </div>

                    <div class='form-group'>
                        <label>Nacionalidade *</label>
                        <input type='text' class='form-control' name='nacionalidade' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>CEP *</label>
                        <input type='text' class='form-control cep-mask' name='cep' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Estado *</label>

                        <select class="form-control" name='id_uf'>
                            <option value="">Selecione uma opção</option>
                            @foreach(\App\Uf::get() as $uf)
                            <option value="{{$uf->id}}">{{$uf->nome}}</option>
                            @endforeach
                        </select> 
                    </div>
                    <div class='form-group'>
                        <label>Cidade *</label>
                        <input type='text' class='form-control' name='cidade' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Bairro *</label>
                        <input type='text' class='form-control' name='bairro' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Endereço *</label>
                        <input type='text' class='form-control' name='endereco' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Número *</label>
                        <input type='text' class='form-control numero-mask' name='numero' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Complemento</label>
                        <input type='text' class='form-control' name='complemento' value=""/>
                    </div>

                    <div class="form-group">
                        <label>É o sócio principal? *</label>
                        <div class="clearfix"></div>
                        <label class='form-control'><input id="principal-sim" type="radio" name="principal" value="1" checked/> Sim</label>
                        <label class='form-control'><input id="principal-nao" type="radio" name="principal" value="0"/> Não</label>
                    </div> 
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="adicionar-socio">Adicionar Sócio</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="mensalidade-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"  style="width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mensalidade</h4>
            </div>
            <div class="modal-body">
                <p>Complete os campos abaixo e confira os valores de nossas mensalidades.
                    <br />Ao cadastrar sua empresa você receberá <b>30 dias grátis</b> em nosso sistema, somente após esse período de 30 dias é que começaremos a cobrar mensalidade.</p>
                <div class='col-xs-6'>
                    <div class='form-group'>
                        <label>Quantos sócios retiram pró-labore? <span data-trigger="hover" class="text-info" title="Pró-labore é o salário dos sócios que constam no contrato social da empresa, e recolhem o INSS mensalmente para a previdência social." data-toggle="tooltip" data-placement="top">(o que é isso?)</span></label>
                        <input type='text' class='form-control numero-mask2' id='pro_labores' name="pro_labores" data-mask-placeholder='0' value="0"/>
                    </div>
                    <div class='form-group'>
                        <label> Quantos documentos fiscais são emitidos e recebidos por mês? <span data-trigger="hover" class="text-info" title="Documentos fiscais, são as notas fiscais de venda ou prestação de serviço emitidas, e as notas fiscais de aquisição de mercadorias ou serviços." data-toggle="tooltip" data-placement="top" >(o que é isso?)</span></label>
                        <input type='text' class='form-control numero-mask2' id='total_documentos' name="total_documentos" data-mask-placeholder='0' value="0"/>
                    </div>
                    <div class='form-group'>
                        <label> Quantos documentos contábeis são emitidos por mês? <span data-trigger="hover" class="text-info" title="Neste item estão a movimentação bancária, em que cada transação corresponde a um documento contábil, assim como recibos de aluguel. Cada valor corresponderá a um documento contábil." data-toggle="tooltip" data-placement="top" >(o que é isso?)</span></label>
                        <input type='text' class='form-control numero-mask2' id='total_contabeis' name="total_contabeis" data-mask-placeholder='0' value="0"/>
                    </div>
                    <div class='form-group'>
                        <label>Quanto você paga hoje por mês para sua contabilidade?</label>
                        <input type='text' class='form-control dinheiro-mask2' id='contabilidade' name="contabilidade" data-mask-placeholder='0' value="499,99"/>
                    </div>
                </div>
                <div class='col-xs-6'>
                    <h2 class='text-center'>Sua mensalidade será:</h2>
                    <div id='mensalidade' class='text-center text-info' style="font-size:45px; font-weight: bold;">R$0,00</div>
                    <h2 class='text-center'>Você <b>economizará</b> por ano:</h2>
                    <div id='economia' class='text-center text-success' style="font-size:45px; font-weight: bold;">R$0,00</div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="cadastrar-empresa">Confirmar dados e continuar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar Janela</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="cnae-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"  style="width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pesquisar CNAE</h4>
            </div>
            <div class="modal-body">
                <p>Digite parte da descrição e pressione pesquisar. Algumas opções irão aparecer, selecione a desejada clicando em "adicionar".</p>
                <form id="cnae-form">
                    <div class='form-group'>
                        <label>CNAE</label>
                        <div class='input-group col-md-12'>
                            <input type='text' id="cnae-search" class='form-control'/>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info" disabled="disabled"><span class="fa fa-search"></span> Pesquisar</button>
                            </span>
                        </div>
                    </div>
                </form>
                <table class='table table-striped'>

                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Código</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id='lista-cnaes-modal'>
                        <tr  class="nenhum-cnae-modal">
                            <td colspan="3">Nenhum CNAE encontrado.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar Janela</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop