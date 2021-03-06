@extends('layouts.dashboard')
@section('header_title', 'Solicitar abertura de empresa')
@section('js')
@parent
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type='text/javascript'>

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
                if ($('#socio-form').data('id') >= 0) {
                    id = parseInt($('#socio-form').data('id'));
                    $("#socios socio[" + id + "]").remove();
                    $('#socio-form').removeData('id');
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
                    if (arrSocio[i].name == 'principal' && parseInt(arrSocio[i].value) == 1) {
                        for (a = 0; a <= id; a++) {
                            $('input[name="socio[' + a + ']principal"]').val(0);
                        }
                    }
                    $('#socios').append('<input type="hidden" name="socio[' + id + '][' + arrSocio[i].name + ']" value="' + arrSocio[i].value + '" data-id="' + id + '" />');
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
                var name = $(this).attr('name');
                var value = $(this).val();
                name = name.replace('socio[' + id + '][', '');
                name = name.replace(']', '');
                if (name != 'principal') {
                    if (name == 'estado_civil' || name == 'regime_casamento' || name == 'id_uf') {
                        $('select[name="' + name + '"] option').each(function () {
                            if ($(this).val() == value) {
                                $(this).prop('selected', true);
                            }
                        });
                    }
                    $('#socio-form input[name="' + name + '"]').val($(this).val());
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

    $("#cadastrar").on('click', function (e) {
        var arrEmpresa = $('#principal-form').serializeArray();
        $.post("{{route('ajax-validar-abertura-empresa')}}", arrEmpresa, function (data) {
            if (data.length) {
                var html = '<ul>';
                for (i in data) {
                    html += '<li>' + data[i] + '</li>';
                }
                html += '</ul>';
                $('#empresa-erros').html(html);
                $('#dash-container').animate({
                    scrollTop: $("#empresa-erros").offset().top
                }, 1000);
                $('#principal-form .alert').show();
            } else {
                $('#principal-form').submit();
            }
        });
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
    $('[data-toggle="tooltip"]').tooltip()
});
</script>
@stop
@section('main')

<div class='card'>
    <h1>Solicitar abertura de empresa</h1>

    <div class='clearfix'></div>
    @if($errors->has())
    <div class="alert alert-warning animate shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif

    <form method="POST" action="" id="principal-form"  enctype="multipart/form-data">
        <h3>Informações</h3>
        <div class="alert alert-warning animate shake" style="display: none">
            <b>Atenção</b><br />
            <div id="empresa-erros"></div>
        </div>

        {{ csrf_field() }}
        <input type="hidden" value="J" name='tipo' />
        <div class='col-md-12'>
            <p>Preencha os campos abaixo e clique em "enviar solicitação" para que possamos dar início ao processo de abertura de empresa.Se precisarmos de mais alguma informação entraremos diretamente em contato com você.</p>
            <p>Campos com * são obrigatórios.</p>
            <p>É necessário que você nos forneça 3 possíveis nomes para sua empresa para que possamos fazer uma análise de viabilidade.</p>
            <br />
        </div>
        <div class="col-md-6">
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
        </div>
        <div class="col-md-6">
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

        </div>
        <div class="col-md-12">
            <div class='form-group'>
                <label>Capital Social * <span data-trigger="hover" class="text-info" title="Capital Social é o valor, a integralizar ou integralizado, correspondente à contra-partida do titular, sócios ou acionistas de um empreendimento, para o início ou a manutenção dos negócios. Para fins de registro do comércio, deverá constar, no documento de constituição empresarial, o montante da subscrição, e como sera feita a conferência do valor: em moeda corrente, bens ou direitos." data-toggle="tooltip" data-placement="top">(o que é isso?)</span></label>
                <p>Descreva o capital social da empresa</p>
                <textarea class='form-control' name='capital_social'>{{Input::old('capital_social')}}</textarea>
            </div>
        </div>
        <div class="clearfix"></div>
        <br />
        <h3>Endereço</h3>
        <div class='col-md-12'>
        <p>Complete os campos abaixo com o endereço da sua empresa.</p>
        </div>
        <div class="col-md-6">
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
        </div>
        <div class="col-md-6">
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
        </div>
        <div class="clearfix"></div>
        <br />
        <h3>Sócios</h3>
        <div class='col-md-12'>
        <p>Clique em 'Adicionar novo sócio' para cadastrar um sócio.</p><p><b>Atenção:</b> É necessário ter pelo menos um sócio cadastrado.</p>
        </div>
        
        <div class="col-md-12">
            <div id='socios'></div>

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
            <div class='form-group'>
                <button id="mostrar-socio" type="button" class='btn btn-primary'><span class="fa fa-plus"></span> Adicionar novo sócio</button>
            </div>
        </div>
        <div class="clearfix"></div>
        <br />
        <h3>CNAEs</h3>
        <div class='col-md-12'>
        <p>Adicione os CNAEs relacionados à sua empresa. Caso não saiba os códigos, clique em Pesquisar CNAE.</p>
        <p><b>Atenção:</b> não adicione nenhum CNAE caso você não saiba quais CNAEs você deseja ou se precisa de ajuda.</p>
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

        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Caso tenha dúvida na escolha de seu CNAE, digite no campo abaixo a descrição detalhada da(s) atividade(s) que pretende realizar em sua empresa e retornaremos com a lista dos possíveis CNAE's.</label>
                <textarea class="form-control" name="cnae_duvida"></textarea>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class='form-group'>
                <button type="button" id="cadastrar" class='btn btn-success'><span class="fa fa-send"></span> Enviar solicitação</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
    </form>
    <div class='clearfix'></div>
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
                            <option value="nenhum">Nenhuma das opções</option>
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