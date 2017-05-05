@extends('layouts.dashboard')
@section('header_title', 'Empresas')
@section('js')
@parent
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
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
            $('#total_documentos, #contabilidade, #total_contabeis, #pro_labores, #funcionarios').clone().appendTo('#principal-form');
            $('#principal-form').submit();
        });

    });
</script>
@stop
@section('main')

<div class='card'>
    <h1>Migrar Empresa</h1>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <form method="POST" action="" id="principal-form">
        <h3>Informações</h3>
        <div class='col-xs-12'>
            <p>Preencha os campos abaixo e clique em "solicitar migração" para iniciarmos o processo de migração de sua empresa para a WEBContabilidade.
                <br /><b>Campos com * são obrigatórios.</b></p>
        </div>
        {{ csrf_field() }}
        <input type="hidden" value="J" name='tipo' />
        <div class='col-md-6'>
            <div class='form-group'>
                <label>Nome Fantasia *</label>
                <input type='text' class='form-control' name='nome_fantasia' value="{{Input::old('nome_fantasia')}}"/>
            </div>
            <div class='form-group'>
                <label>Razão Social *</label>
                <input type='text' class='form-control' name='razao_social' value="{{Input::old('razao_social')}}" />
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
                <label>CNPJ *</label>
                <input type='text' class='form-control cnpj-mask' name='cpf_cnpj' value="{{Input::old('cpf_cnpj')}}"/>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label>Inscrição Estadual</label>
                <input type='text' class='form-control' name='inscricao_estadual'  value="{{Input::old('inscricao_estadual')}}"/>
            </div>
            <div class='form-group'>
                <label>Inscrição Municipal</label>
                <input type='text' class='form-control' name='inscricao_municipal' value="{{Input::old('inscricao_municipal')}}" />
            </div>
            <div class='form-group'>
                <label>IPTU</label>
                <input type='text' class='form-control' name='iptu'  value="{{Input::old('iptu')}}"/>
            </div>
        </div>
        <div class='clearfix'></div>
        <br />
        <h3>Endereço</h3>
        <div class='col-xs-12'><p>Complete os campos abaixo com o endereço da sua empresa.</p></div>
        <div class='col-md-6'>
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
        </div>
        <div class='col-md-6'>
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
        </div>
        <div class='clearfix'></div>
        <br />
        <h3>Sócio Responsável</h3>
        <div class='col-xs-12'><p>Complete os campos abaixo com as informações do <b>sócio responsável pela empresa perante a Receita Federal</b><br />
                <b>Atenção:</b> Essas informações são importantes para automatizarmos processos contábeis junto com os sistemas do governo.</p></div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label>Nome do responsável *</label>
                <input type='text' class='form-control' name='socio[nome]' value="{{Input::old('socio')['nome']}}" />
            </div> 
            <div class='form-group'>
                <label>Data de Nascimento *</label>
                <input type='text' class='form-control date-mask' name='socio[data_nascimento]' value="{{Input::old('socio')['data_nascimento']}}" />
            </div>
            <div class='form-group'>
                <label>Telefone do responsável *</label>
                <input type='text' class='form-control fone-mask' name='socio[telefone]' value="{{Input::old('socio')['telefone']}}" />
            </div>

            <div class='form-group'>
                <label>CPF do responsável *</label>
                <input type='text' class='form-control cpf-mask' name='socio[cpf]' value="{{Input::old('socio')['cpf']}}"/>
            </div>
            <div class='form-group'>
                <label>RG do responsável *</label>
                <input type='text' class='form-control' name='socio[rg]' value="{{Input::old('socio')['rg']}}"/>
            </div>
            <div class='form-group'>
                <label>Órgão Expedidor do RG (Ex: SSP/SC) *</label>
                <input type='text' class='form-control' name='socio[orgao_expedidor]' value="{{Input::old('socio')['orgao_expedidor']}}"/>
            </div>
           
            <div class='form-group'>
                <label>Nº Título de Eleitor do responsável *</label>
                <input type='text' class='form-control' name='socio[titulo_eleitor]' value="{{Input::old('socio')['titulo_eleitor']}}"/>
            </div>

            <div class='form-group'>
                <label>PIS do responsável</label>
                <input type='text' class='form-control pis-mask' name='socio[pis]' value="{{Input::old('socio')['pis']}}"/>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label>CEP do responsável*</label>
                <input type='text' class='form-control cep-mask' name='socio[cep]' value="{{Input::old('socio')['cep']}}"/>
            </div>
            <div class='form-group'>
                <label>Estado do responsável *</label>

                <select class="form-control" name='socio[id_uf]'>
                    <option value="">Selecione uma opção</option>
                    @foreach(\App\Uf::get() as $uf)
                    <option value="{{$uf->id}}" {{Input::old('socio')['id_uf'] == $uf->id ? 'selected' : null}}>{{$uf->nome}}</option>
                    @endforeach
                </select> 
            </div>
            <div class='form-group'>
                <label>Cidade do responsável *</label>
                <input type='text' class='form-control' name='socio[cidade]' value="{{Input::old('socio')['cidade']}}"/>
            </div>
            <div class='form-group'>
                <label>Endereço do responsável *</label>
                <input type='text' class='form-control' name='socio[endereco]' value="{{Input::old('socio')['endereco']}}"/>
            </div>
            <div class='form-group'>
                <label>Bairro do responsável *</label>
                <input type='text' class='form-control' name='socio[bairro]' value="{{Input::old('socio')['bairro']}}"/>
            </div>
            <div class='form-group'>
                <label>Nº do Último Recibo do Imposto de Renda do responsável (Deixe em branco caso não tenha declarado)</label>
                <input type='text' class='form-control irpf-mask' name='socio[recibo_ir]' value="{{Input::old('socio')['recibo_ir']}}"/>
            </div>
            <div class='form-group'>
                <label>Valor de Pró-Labore do responsável (Deixe em branco caso não receba pró-labore)</label>
                <input type='text' class='form-control dinheiro-mask' name='socio[pro_labore]' value="{{Input::old('socio')['pro_labore']}}"/>
            </div>
             <div class='form-group'>
                <label>Código de Acesso do Simples Nacional *</label>
                <input type='text' class='form-control' name='codigo_acesso_simples_nacional' value="{{Input::old('codigo_acesso_simples_nacional')}}"/>
            </div>
            <input type='hidden' name='socio[principal]' value="1"/>
        </div>
        <div class='clearfix'></div>
        <br />
        <h3>CNAEs</h3>
        <div class='col-xs-12'>
            <p>Adicione os CNAEs relacionados à sua empresa. Caso não saiba os códigos, clique em Pesquisar CNAE.</p>
        </div>
        <div class='col-xs-12'>
            <div class='form-group'>
                <label>CNAE *</label>
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
                        <td colspan="3" class="nenhum-cnae">Por favor adicione pelo menos um CNAE.</td>
                    </tr>
                </tbody>
            </table>     
        </div>
        <div class='clearfix'></div>
        <br />
        <h3>Contabilidade Atual (Migração para WEBContabilidade)</h3>
        <div class='col-xs-12'>
            <p>Precisamos que você informe o número de registro do CRC do seu atual contador para que possamos dar início ao processo de transferência de sua empresa.</p>
        </div>
        <div class='col-xs-12'>
            <div class='form-group'>
                <label>Número de registro do CRC do contador atual *</label>
                <input type='text' class='form-control' name='crc' value="{{Input::old('crc')}}"/>
            </div>
        </div>
        <div class='clearfix'></div>
        <br />
        <div class='col-xs-12'>
            <div class='form-group'>
                <a href="" id="mostrar-simulador" class='btn btn-success'><span class='fa fa-exchange'></span> Solicitar Migração</a>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
    </form>
    <div class='clearfix'></div>
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
                <div class='col-xs-12'>
                    <p>Complete os campos abaixo e confira os valores de nossas mensalidades.
                        <br />Após migrarmos sua empresa, você receberá <b>30 dias grátis</b> em nosso sistema. Somente após esse período de 30 dias é que começaremos a cobrar a mensalidade.</p>
                </div>
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
                <div class='col-xs-12'>
                    <p>Digite parte da descrição e pressione pesquisar. Algumas opções irão aparecer, selecione a desejada clicando em "adicionar".</p>
                </div>
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
                            <th style="min-width: 100px;">Código</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id='lista-cnaes-modal'>
                        <tr class="nenhum-cnae-modal">
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