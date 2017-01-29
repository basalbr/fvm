@extends('layouts.dashboard')
@section('header_title', 'Chamados')
@section('js')
@parent
<script type="text/javascript">
    $(function () {
        var contador = 0;
        $('#descricao').on('change', function () {
            if ($(this).val() == 'outro') {
                $('#descricao-field').removeClass('hidden');
            } else {
                $('#descricao-field').addClass('hidden');
                $('[name="descricao"]').val($(this).val());
            }
        });
        $('#anexar').on('click', function (e) {
            $('#lista-erros').empty();
            e.preventDefault();
            if (!$('[name="descricao"]').val()) {
                $('#lista-erros').append('<p>É necessário informar o tipo do documento anexado.</p>');
                $('#erro-modal').modal('show');
                return;
            }
            var form = $(this).parent().parent().parent();
            var data = new FormData($('form#anexar-arquivo')[0]);
            $('#espere-modal').modal('show');
            $.ajax({url: form.attr('action'), method: 'POST', data: data, contentType: false, cache: false, processData: false, success: function (res) {
                    $('#espere-modal').modal('hide');
                    $('form#enviar-arquivos').append('<input data-id="' + contador + '" type="hidden" value="' + res.documento + '" name="documentos[' + contador + '][anexo]" />');
                    $('form#enviar-arquivos').append('<input data-id="' + contador + '" type="hidden" value="' + $('[name="descricao"]').val() + '" name="documentos[' + contador + '][descricao]" />');
                    var html = '<tr><td>' + $('[name="descricao"]').val() + '</td><td><button class="btn btn-danger" data-id="' + contador + '"><span class="fa fa-remove"></span> Remover</button></td></tr>';
                    $('#lista-anexos').append(html);
                    $('form')[0].reset();
                    $('#descricao-field').addClass('hidden');
                    contador++;
                }, error: function (xhqr) {
                    $('#espere-modal').modal('hide');
                    var data = xhqr.responseJSON;
                    for (i in data.erros) {
                        $('#lista-erros').append('<p>' + data['erros'][i] + '</p>');
                    }
                    $('#erro-modal').modal('show');
                }});
        });
        $('#lista-anexos').on('click', '.btn-danger', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('input[type="hidden"]').each(function () {
                if ($(this).data('id') == id) {
                    $(this).remove();
                }
            }, id);
            $(this).parent().parent().remove();
        });
    });
</script>
@stop
@section('main')


<div class="card">
    <h1>Enviar Documentos</h1>

    <h3>Anexar Documento</h3>

    <div class="clearfix"></div>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br/>
        @foreach ($errors->all() as $error)
        {{ $error }}<br/>
        @endforeach
    </div>
    @endif
    <div class='col-xs-12'>
        <p>Selecione o tipo de documento que deseja enviar, selecione o respectivo documento em seu computador eclique em anexar.</p>
    </div>
    <form id="anexar-arquivo" method="POST" action="{{route('upload-documento-contabil',[$processo_id])}}" enctype="multipart/form-data">
        <div class="col-md-12">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Tipo de Documento</label>
                <select class="form-control" id="descricao">
                    <option value="">Selecione uma opção</option>
                    @foreach($tipos as $tipo)
                    <option value="{{$tipo->descricao}}">{{$tipo->descricao}}</option>
                    @endforeach
                    <option value="outro">Outro</option>
                </select>
            </div>
            <div class='form-group hidden' id="descricao-field">
                <label>Outro (digite a descrição)</label>
                <input type='text' class='form-control' name='descricao' value=""/>
            </div>
            <div class='form-group'>
                <label>Documento</label>
                <input type='file' class='form-control' value="" name='anexo'/>
            </div>
            <div class='form-group'>
                <button type='button' id="anexar" class='btn btn-primary'><span class='fa fa-plus'></span> Anexar</button>
            </div>

        </div>
    </form>
    <div class="clearfix"></div>
    <br/>
    <h3>Lista de Documentos</h3>
    <div class="col-xs-12">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="lista-anexos"></tbody>
        </table>
        <form id="enviar-arquivos" method="POST">
            {{ csrf_field() }}
            <div class='form-group'>
                <button type='submit' class='btn btn-success'><span class='fa fa-send'></span> Enviar Documentos Anexados</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>

</div>
@stop
@section('modal')
<div class="modal fade" id="espere-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"  style="width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Carregando Documento</h4>
            </div>
            <div class="modal-body">
                <div class='col-xs-12'>
                    <p>Estamos carregando o documento em nosso servidor, por favor aguarde um instante.</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="erro-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"  style="width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Atenção</h4>
            </div>
            <div class="modal-body">
                <div class='col-xs-12'>
                    <div class='alert alert-warning'  id='lista-erros'></div>
                </div>
                <div class='clearfix'></div>
                 <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop