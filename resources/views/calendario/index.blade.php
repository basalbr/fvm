@extends('layouts.dashboard')
@section('header_title', 'Calendário de Impostos')
@section('js')
@parent
<script type="text/javascript" language="javascript">
$(function(){
    $('#calendar').fullCalendar({
        height:'auto',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        lang: 'pt-br',
        events: {
            url: "{{route('ajax-calendar')}}",
            type: 'POST'
        },
        eventClick: function (calEvent) {
            $('.fc-event').each(function () {
                $(this).removeClass('fc-event-success');
            });
            $(this).addClass('fc-event-success');
            $.get("{{route('ajax-instrucoes')}}", {'id': calEvent.id}, function (data) {
                if (data.length !== undefined) {
                    if (data.length > 0) {
                        $('.modal-header').text(calEvent.title)
                        var html = "<div class='col-xs-12'>\n\
                                    <input type='hidden' id='instrucao-page' value='1' />\n\
                                    <input type='hidden' id='instrucao-total' value='" + data.length + "' />";
                        html += '<h2 style="margin-bottom:15px; margin-top:0; padding:0;">' + calEvent.title + '</h2>';
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
        }
    });

});
</script>
@stop
@section('main')
<h1 class="header">Calendário de Impostos</h1>
<hr class="dash-title">
<div class="col-xs-12 card">
    <div id="calendar"></div>
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