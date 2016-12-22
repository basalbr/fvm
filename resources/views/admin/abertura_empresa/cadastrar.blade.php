@extends('layouts.admin')
@section('header_title', 'Empresas')
@section('js')
@parent
<script type='text/javascript'>
    var planos;
    var max_documentos;
    var max_contabeis;
    var max_pro_labores;
    var maxValor;
    var minValor;
    $(function () {
         $.get("{{route('ajax-simular-plano')}}", function (data) {
            planos = data.planos;
//            max_funcionarios = parseInt(data.total_funcionarios);
            max_documentos = parseInt(data.max_documentos);
            max_contabeis = parseInt(data.max_contabeis);
            max_pro_labores = parseInt(data.max_pro_labores);
            maxValor = parseFloat(data.max_valor);
            contabilidade = parseFloat($('#contabilidade').val().replace(RegExp, "$1.$2"));

            economia = (contabilidade * 12) - (parseFloat(data.min_valor) * 12);
            $('#mensalidade').text('R$' + parseFloat(data.min_valor).toFixed(2));
            $('#economia').text('R$' + economia.toFixed(2));
        });
        $('#total_documentos, #funcionarios, #contabilidade, #total_contabeis, #pro_labores').on('keyup', function () {
            var funcionarios = $('#funcionarios').val() ? parseInt($('#funcionarios').val()) : 0;
            var acrescimo_funcionarios = 0;
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
            if (funcionarios >= 10) {
                acrescimo_funcionarios = funcionarios * 20;
            } else {
                acrescimo_funcionarios = funcionarios * 25;
            }


            for (i in planos) {

                if (total_contabeis <= parseInt(planos[i].total_documentos_contabeis) && total_documentos <= parseInt(planos[i].total_documentos) && pro_labores <= parseInt(planos[i].pro_labores) && parseFloat(planos[i].valor) < minValor) {
                    minValor = parseFloat(planos[i].valor);
                }
            }
            minValor = parseFloat(minValor + acrescimo_funcionarios).toFixed(2);
            $('#mensalidade').text('R$' + minValor);
            contabilidade = $('#contabilidade').val().replace(".", "");
            contabilidade = parseFloat(contabilidade.replace(",", "."));
            totalDesconto = (contabilidade * 12) - (minValor * 12) > 0 ? (contabilidade * 12) - (minValor * 12) : 0;

            $('#economia').html('R$' + totalDesconto.toFixed(2));

        });
        $('#mostrar-simulador').on('click', function (e) {
            e.preventDefault();
            $('#mensalidade-modal').modal('show');
        });

        $('#cadastrar-empresa').on('click', function (e) {
            e.preventDefault();
            $('#total_documentos, #contabilidade, #total_contabeis, #pro_labores, #funcionarios').clone().appendTo('#principal-form');
            $('#principal-form').submit();
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
            $.post("{{route('ajax-validar-socio-empresa')}}", arrSocio, function (data) {
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
                $.post("{{route('ajax-cnae')}}", {tipo: codigo, search: $(this).val()}, function (data) {
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

    });
</script>
@stop
@section('main')
<div class='card'>
    <h1>Cadastrar Empresa</h1>

    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <form method="POST" action="" id="principal-form">
        <input type='hidden' value='{{$empresa->usuario->id}}' name='id_usuario'>
        {{ csrf_field() }}
        <h3>Informações</h3>
        <div class='col-xs-12'>
            <p>Preencha os campos abaixo e clique em "cadastrar" para cadastrar a empresa para o usuário <b>{{$empresa->usuario->nome}}</b>.</p>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label>Nome Fantasia</label>
                <input type='hidden' name='tipo' value="J"/>
                <input type='text' class='form-control' name='nome_fantasia' value="{{$empresa->nome_empresarial1}}"/>
            </div>
            <div class='form-group'>
                <label>Razão Social</label>
                <input type='text' class='form-control' name='razao_social' value="" />
            </div>
            <div class='form-group'>
                <label>Natureza Jurídica</label>
                <select class="form-control" name="id_natureza_juridica">
                    <option value="">Selecione uma opção</option>
                    @foreach(\App\NaturezaJuridica::all() as $natureza_juridica)
                    <option value="{{$natureza_juridica->id}}" {{$natureza_juridica->id == $empresa->id_natureza_juridica ? 'selected':''}}>{{$natureza_juridica->descricao}}</option>
                    @endforeach
                </select>
            </div>

            <div class='form-group'>
                <label>CNPJ</label>
                <input type='text' class='form-control cnpj-mask' name='cpf_cnpj' value=""/>
            </div>

            <div class='form-group'>
                <label>Inscrição Estadual</label>
                <input type='text' class='form-control' name='inscricao_estadual'  value=""/>
            </div>

        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label>Inscrição Municipal</label>
                <input type='text' class='form-control' name='inscricao_municipal' value="" />
            </div>
            <div class='form-group'>
                <label>IPTU</label>
                <input type='text' class='form-control' name='iptu'  value="{{$empresa->iptu}}"/>
            </div>
            <div class='form-group'>
                <label>Quantidade de Funcionários</label>
                <input type='text' class='form-control' name='qtde_funcionarios'  value="{{Input::old('qtde_funcionarios')}}"/>
            </div>
            <div class='form-group'>
                <label>Código de Acesso do Simples Nacional</label>
                <input type='text' class='form-control' name='codigo_acesso_simples_nacional' value=""/>
            </div>
        </div>
        <div class='clearfix'></div>
        <br />
        <h3>Endereço</h3>
        <div class='col-xs-12'>
        <p>Complete os campos abaixo com o endereço da sua empresa.</p>
        </div>
        <div class='col-md-6'>
        <div class='form-group'>
            <label>CEP</label>
            <input type='text' class='form-control cep-mask' name='cep' value="{{$empresa->cep}}" />
        </div>
        <div class='form-group'>
            <label>Estado</label>
            <select class="form-control" name='id_uf'>
                <option value="24">Santa Catarina</option>
            </select> 
        </div>
        <div class='form-group'>
            <label>Cidade</label>
            <input type='text' class='form-control' name='cidade'  value="{{$empresa->cidade}}"/>
        </div>
        </div>
        <div class='col-md-6'>
        <div class='form-group'>
            <label>Endereço</label>
            <input type='text' class='form-control' name='endereco'  value="{{$empresa->endereco}}"/>
        </div>
        <div class='form-group'>
            <label>Bairro</label>
            <input type='text' class='form-control' name='bairro'  value="{{$empresa->bairro}}"/>
        </div>
        <div class='form-group'>
            <label>Número</label>
            <input type='text' class='form-control numero-mask' name='numero' value="{{$empresa->numero}}"/>
        </div>
        </div>
        <div class='clearfix'></div>
        <br />
        <h3>Sócios</h3>
        <div class='col-xs-12'>
        <p>Clique em 'Adicionar novo sócio' para cadastrar um sócio.</p><p><b>Atenção:</b> É necessário ter pelo menos um sócio cadastrado.</p>
        <div id='socios'>
            @foreach($empresa->socios as $socio)
            <input type='hidden' name='socio[{{$socio->id}}][nome]' value="{{$socio->nome}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][email]' value="{{$socio->email}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][nome_mae]' value="{{$socio->nome_mae}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][nome_pai]' value="{{$socio->nome_pai}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][data_nascimento]' value="{{$socio->data_nascimento}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][estado_civil]' value="{{$socio->estado_civil}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][regime_casamento]' value="{{$socio->regime_casamento}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][telefone]' value="{{$socio->telefone}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][cpf]' value="{{$socio->cpf}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][rg]' value="{{$socio->rg}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][orgao_expedidor]' value="{{$socio->orgao_expedidor}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][nacionalidade]' value="{{$socio->nacionalidade}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][cep]' value="{{$socio->cep}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][id_uf]' value="{{$socio->id_uf}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][cidade]' value="{{$socio->cidade}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][bairro]' value="{{$socio->bairro}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][endereco]' value="{{$socio->endereco}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][numero]' value="{{$socio->numero}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][complemento]' value="{{$socio->complemento}}" data-id="{{$socio->id}}"/>
            <input type='hidden' name='socio[{{$socio->id}}][principal]' value="{{$socio->principal}}" data-id="{{$socio->id}}"/>
            @endforeach
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
                <tr><td colspan="3" class="nenhum-socio" style="display: none;">Por favor adicione pelo menos um Sócio.</td><tr/>
                @foreach($empresa->socios as $socio)
                <tr>
                    <td>{{$socio->nome}}</td>
                    <td>{{$socio->cpf}}</td>
                    <td>
                        <button type='button' class='btn btn-warning editar-socio' data-id='{{$socio->id}}'><span class='fa fa-edit'></span> Editar</button> 
                        <button type='button' class='btn btn-danger remover-socio' data-id='{{$socio->id}}'><span class='fa fa-remove'></span> Remover</button>
                    </td>
                </tr>
                @endforeach
                </tr>
            </tbody>
        </table> 
        <div class='form-group'>
            <button id="mostrar-socio" type="button" class='btn btn-primary'><span class='fa fa-plus'></span> Adicionar novo sócio</button>
        </div>
        </div>
        <div class='clearfix'></div>
        <br />
        <h3>CNAEs</h3>
        <div class='col-md-12'>
        <p>Adicione os CNAEs relacionados à sua empresa. Caso não saiba os códigos, clique em Pesquisar CNAE.</p>
        
        <table class='table table-striped'>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Código</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id='lista-cnaes'>
                @if($empresa->cnaes->count())
                <tr><td colspan="3" class="nenhum-cnae" style="display: none;">Por favor adicione pelo menos um CNAE.</td><tr/>
                @foreach($empresa->cnaes as $cnae)
                <tr>
                    <td>{{$cnae->cnae->descricao}}</td>
                    <td>{{$cnae->cnae->codigo}}</td>
                    <td>

                        <button type='button' class='btn btn-danger remover-cnae' data-id='{{$cnae->cnae->id}}'><span class='fa fa-remove'></span> Remover</button>
                    </td>
            <input type="hidden" value="{{$cnae->cnae->id}}" name="cnaes[]"/>
            </tr>
            @endforeach
            @else
            <tr><td colspan="3" class="nenhum-cnae">Por favor adicione pelo menos um CNAE.</td><tr/>
            @endif


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
        <hr>
        <div class='form-group'>
            <button type='button' id="mostrar-simulador" class='btn btn-success'><span class='fa fa-plus'></span> Cadastrar Empresa</button>
        </div>
        </div>
        <div class='clearfix'></div>
    </form>
</div>
@stop

@section('modal')
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
                        <label>Quantos funcionários possui? <span data-trigger="hover" class="text-info" title="Quantidade de funcionários registrados na empresa. Exigido certificado digital A1." data-toggle="tooltip" data-placement="top">(o que é isso?)</span></label>
                        <input type='text' class='form-control numero-mask2' id='funcionarios' data-mask-placeholder='0' />
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
                        <label>Telefone *</label>
                        <input type='text' class='form-control fone-mask' name='telefone' value="" />
                    </div>
                    <div class='form-group'>
                        <label>Recibo do Imposto de Renda</label>
                        <input type='text' class='form-control' name='recibo_ir' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Título de Eleitor</label>
                        <input type='text' class='form-control' name='titulo_eleitor' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>PIS</label>
                        <input type='text' class='form-control' name='pis' value=""/>
                    </div>
                    <div class='form-group'>
                        <label>Pró-Labore</label>
                        <input type='text' class='form-control' name='pro_labore' value=""/>
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
@stop