@extends('layouts.admin')
@section('header_title', 'Empresas')
@section('js')
@parent
<script type='text/javascript'>
    $(function () {

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
<h1>Editar Empresa</h1>
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
        <form method="POST" action="" id="principal-form">

            {{ csrf_field() }}
            <h3>Informações</h3>
            <p>Preencha os campos abaixo e clique em "salvar atelrações" para atualizar os dados de sua empresa em nosso sistema.</p>
            <div class='form-group'>
                <label>Nome Fantasia</label>
                <input type='text' class='form-control' name='nome_fantasia' value="{{$empresa->nome_fantasia}}"/>
            </div>
            <div class='form-group'>
                <label>Razão Social</label>
                <input type='text' class='form-control' name='razao_social' value="{{$empresa->razao_social}}" />
            </div>
            <div class='form-group'>
                <label>Natureza Jurídica</label>
                <select class="form-control" name="id_natureza_juridica">
                    <option value="">Selecione uma opção</option>
                    @foreach($naturezasJuridicas as $natureza_juridica)
                    <option value="{{$natureza_juridica->id}}" {{$natureza_juridica->id == $empresa->id_natureza_juridica ? 'selected':''}}>{{$natureza_juridica->descricao}}</option>
                    @endforeach
                </select>
            </div>

            <div class='form-group'>
                <label>CNPJ</label>
                <input type='text' class='form-control cnpj-mask' name='cpf_cnpj' value="{{$empresa->cpf_cnpj}}"/>
            </div>

            <div class='form-group'>
                <label>Inscrição Estadual</label>
                <input type='text' class='form-control' name='inscricao_estadual'  value="{{$empresa->inscricao_estadual}}"/>
            </div>
            <div class='form-group'>
                <label>Inscrição Municipal</label>
                <input type='text' class='form-control' name='inscricao_municipal' value="{{$empresa->inscricao_municipal}}" />
            </div>
            <div class='form-group'>
                <label>IPTU</label>
                <input type='text' class='form-control' name='iptu'  value="{{$empresa->iptu}}"/>
            </div>
            <div class='form-group'>
                <label>Código de Acesso do Simples Nacional</label>
                <input type='text' class='form-control' name='codigo_acesso_simples_nacional' value="{{$empresa->codigo_acesso_simples_nacional}}"/>
            </div>
            <h3>Endereço</h3>
            <p>Complete os campos abaixo com o endereço da sua empresa.</p>
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

            <h3>CNAEs</h3>
            <p>Adicione os CNAEs relacionados à sua empresa. Caso não saiba os códigos, clique em Pesquisar CNAE.</p>
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
                    <tr><td colspan="3" class="nenhum-cnae" style="display: none;">Por favor adicione pelo menos um CNAE.</td><tr/>
                    @foreach($empresa->cnaes as $cnae)
                    <tr>
                        <td>{{$cnae->cnae->descricao}}</td><td>{{$cnae->cnae->codigo}}</td><td><button type='button' class='btn btn-danger remover-cnae' data-id='{{$cnae->cnae->id}}'><span class='fa fa-remove'></span> Remover</button></td>
                <input type="hidden" value="{{$cnae->cnae->id}}" name="cnaes[]"/>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class='form-group'>
                <input type='submit' value="Salvar alterações" class='btn btn-primary' />
            </div>
            <div class='clearfix'></div>
        </form>
    </div>
</div>
@stop

@section('modal')
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