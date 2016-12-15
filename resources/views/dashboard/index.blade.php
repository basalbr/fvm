@extends('layouts.dashboard')
@section('js')
@parent()
<script type="text/javascript" language="javascript">
    $(function () {
        $('#lista-notificacao').on('click', '.mark-read', function (e) {
            e.preventDefault();
            $.post("{{route('ajax-notificacao')}}", {'id': $(this).data('id')}, function (data) {
                var html = '';
                for (i in data) {
                    html += '<li><div class="notificacao-mensagem">' + data[i].mensagem + '</div></li>';
                    html += '<li><div class="text-success"><a href="" data-id="' + data[i].id + '" class="text-success mark-read"><span class="fa fa-check"></span> Marcar como lida</a></div></li>'
                }
                $("#lista-notificacao").html(html);
                if ($("#lista-notificacao li").length < 1) {
                    $("#lista-notificacao").html('<li>Você não possui nenhuma notificação</li>');
                }
            });
        });
        $('.imposto-event').on('click', function (e) {
            e.preventDefault();
            var title = $(this).data('title');
            $.get("{{route('ajax-instrucoes')}}", {'id': $(this).data('id')}, function (data) {
                if (data.length !== undefined) {
                    if (data.length > 0) {
                        $('.modal-header').text(title);
                        var html = "<div class='col-xs-12'>\n\
                                    <input type='hidden' id='instrucao-page' value='1' />\n\
                                    <input type='hidden' id='instrucao-total' value='" + data.length + "' />";
                        html += '<h2 style="margin-bottom:15px; margin-top:0; padding:0;">' + title + '</h2>';
                        if (data.length > 1) {
                            html += "<div id='paginacao-instrucao-container'>";
                            html += "<div class='paginacao-instrucao'>Página <span id='pagina-atual' class='numero'>1</span> de <span class='numero'>" + data.length + "</span></div>";
                            html += "<div class='paginacao-botoes'>";
                            html += "<div class='btn btn-primary disabled btn-instrucao-voltar' style='margin-right: 5px'>Voltar</div>";
                            html += "<div class='btn btn-primary btn-instrucao-avancar'>Avançar</div>";
                            html += "</div>";
                            html += "<div class='clearfix'></div>";
                            html += "</div>";
                        }
                        html += "</div>";
                        data.forEach(function (instrucao, key) {
                            if (key == 0) {
                                html += "<div class='col-xs-12 instrucao-descricao' style='display: block' data-pagina='" + (key + 1) + "'>";
                            } else {
                                html += "<div class='col-xs-12 instrucao-descricao' style='display: none' data-pagina='" + (key + 1) + "'>";
                            }
                            html += instrucao.descricao;
                            html += "</div>";
                        }, html);
                        $('.modal-body > p').html(html);
                        $('#imposto-modal').modal('show');
                    }
                }
            })
        })

    });
</script>
@stop
@section('main')
<h1>Central do Cliente</h1>
<p>Seja bem vindo {{Auth::user()->nome}}, utilize os botões no menu esquerdo para navegar em nosso sistema.</p>
<hr class="dash-title">

<div id="apuracao-card" class="col-xs-6">
    <div class='card'>
        <h3>Apurações em aberto</h3>
        <div class="card-body">
            <p><b>Clique em uma apuração para visualizar mais informações.</b></p>
            <ul class='lista-apuracoes-urgentes'>
                @if(count($apuracoes)>0)

                @foreach($apuracoes as $apuracao)
                <li>
                    <a href="{{route('responder-processo-usuario', ['id' => $apuracao->id])}}">
                        <div class='empresa'>{{$apuracao->pessoa->nome_fantasia}}</div>
                        <div class='imposto'>{{$apuracao->imposto->nome}}<span class="btn btn-info pull-right">enviar informações</span></div>
                        <div class='vencimento'>Vencimento: {{$apuracao->vencimento_formatado()}}</div>
                    </a>
                </li>
                @endforeach

                @else
                <li>Você não possui nenhuma apuração em aberto.</li>
                @endif
            </ul>
            <a class="btn btn-info" href="{{route('listar-processos')}}">Visualizar todas as apurações</a>
        </div>
    </div>
</div>

<div id="notificacao-card" class="col-xs-6">
    <div class='card'>
        <h3>Notificações</h3> 
        <div class="card-body">
            <p><b>Abaixo estão os eventos mais recentes.</b></p>
            <ul class='lista-apuracoes-urgentes' id="lista-notificacao">
                @if($notificacoes->count())
                @foreach($notificacoes as $notificacao)
                <li>
                    <div class="notificacao-mensagem">{!!$notificacao->mensagem!!}</div>
                    <div class="text-success"><a href="" data-id="{{$notificacao->id}}" class="text-success mark-read"><span class="fa fa-check"></span> Marcar como lida</a></div>
                </li>
                @endforeach
                @else
                <li>Você não possui nenhuma notificação.</li>
                @endif
            </ul>
        </div>
    </div>
</div>

@stop
@section('modal')
<div class="modal fade" id="imposto-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
                <div class="clearfix"></div>
            </div>
            <div class="modal-body">
                <p></p>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar Janela</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop