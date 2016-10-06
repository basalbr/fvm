@extends('layouts.dashboard')
@section('js')
@parent()
<script type="text/javascript" language="javascript">
$(function(){
  $('.imposto-event').on('click', function(e){
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


<div class='col-xs-8'>
    <div class='card'>
        <h3>Apurações em aberto</h3>
        @if(count($apuracoes)>0)
        <p>Você possui algumas apurações que precisam de informações adicionais.</p>
        <ul class='lista-apuracoes-urgentes'>
            @foreach($apuracoes as $apuracao)
            <li>
                <a href="{{route('responder-processo-usuario', ['id' => $apuracao->id])}}">
                    <div class='empresa'>{{$apuracao->pessoa->nome_fantasia}}</div>
                    <div class='imposto'>{{$apuracao->imposto->nome}}<span class="btn btn-info pull-right">enviar informações</span></div>
                    <div class='vencimento'>Vencimento: {{$apuracao->vencimento_formatado()}}</div>
                </a>
            </li>
            @endforeach
        </ul>
        @else
        <p>Você não possui nenhuma apuração em aberto.</p>
        @endif
    </div>
</div>

<div class='col-xs-4'>
    <div class='card'>
        <h3>Empresas cadastradas</h3> 

        @if($empresas->count())
        <p>Clique em uma empresa para visualizar informações</p>
        <ul class='lista-apuracoes-urgentes'>
            @foreach($empresas as $empresa)
            <li>
                <a href="{{route('editar-empresa', ['id' => $empresa->id])}}">
                    <div class='empresa'>{{$empresa->nome_fantasia}}</div>
                    <div class='imposto'>{{$empresa->cpf_cnpj}}</div>
                </a>
            </li>
            @endforeach
        </ul>
        <a class="btn btn-info" href="{{route('empresas')}}">Visualizar todas as empresas</a>
        @else
        <p>Você não possui nenhuma empresa cadastrada, para utilizar nosso sistema e aproveitar nossos serviços, você precisa cadastrar pelo menos uma empresa.<br/><a href="{{route('cadastrar-empresa')}}" >Clique aqui para cadastrar uma empresa.</a></p>
        @endif
    </div>
</div>

<div class='col-xs-4'>
    <div class='card'>
        <h3>Últimas mensagens</h3> 

        @if($mensagens->count())
        <p>Clique em uma mensagem para abrir a conversa.</p>
        <ul class='lista-apuracoes-urgentes'>
            @foreach($mensagens as $mensagem)
            <li>
                <a href="{{route('responder-chamado-usuario',[$mensagem->id])}}">
                    <div class='empresa'>{{$mensagem->mensagem}}</div>
                    <div class='imposto'>{{$mensagem->usuario->nome}}</div>
                    <div class='vencimento'>Às {{date_format($mensagem->created_at, 'H:i - d/m/y')}}</div>
                </a>
            </li>
            @endforeach
        </ul>
        <a class="btn btn-info" href="{{route('listar-chamados-usuario')}}">Visualizar todas as mensagens</a>
        @else
        <p>Você não possui nenhuma mensagem.</p>
        @endif
    </div>
</div>

<div class='col-xs-4'>
    <div class='card'>
        <h3>Impostos de {{$meses[date('m')]}}</h3> 

        <p>Clique em um imposto para visualizar mais informações</p>
        <ul class='lista-apuracoes-urgentes'>
            @foreach($impostos as $imposto)
            <li>
                <a class="imposto-event" data-title="{{$imposto->nome}}" data-id="{{$imposto->id}}" href="{{route('responder-processo-usuario', ['id' => $imposto->id])}}">
                    <div class='empresa'>{{$imposto->nome}}</div>
                    <div class='imposto'>Vencimento: {{$imposto->vencimento.'/'.$meses[date('m')]}}</div>
                </a>
            </li>
            @endforeach
        </ul>
        <a class="btn btn-info" href="{{route('calendario')}}">Visualizar calendário de impostos</a>
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