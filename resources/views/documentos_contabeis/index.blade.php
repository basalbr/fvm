@extends('layouts.dashboard')
@section('js')
@parent
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url(public_path().'js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript" language="javascript">
$(function () {
    $('.date-mask').on('keypress', function () {
        return false;
    });
    $('.date-mask').datepicker({
        language: 'pt-BR',
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayBtn: 'linked'
    });
});
</script>
@stop
@section('header_title', 'Documentos Contábeis')
@section('main')

<div class="card">
    <h1>Documentos Contábeis</h1>
    <p>Para visualizar os detalhes de uma apuração ou enviar informações adicionar, clique em visualizar.</p>
    <br/>
    <h3>Lista de documentos contábeis</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Período</th>
                <th>Empresa</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if($processos->count())
            @foreach($processos as $processo)
            <tr>
                <td>{{$processo->periodo->format('m/Y')}}</td>
                <td>{{$processo->pessoa->nome_fantasia}}</td>
                <td>{{$processo->status_formatado()}}</td>
                <td>
                    @if($processo->status != 'sem_movimento')
                    <a class='btn btn-primary' href="{{route('listar-documento-contabil',[$processo->id])}}"><span class="fa fa-search"></span> Visualizar</a>
                    @endif
                </td>
            </tr>

            @endforeach
            @else
            <tr>
                <td colspan="4">Nenhum registro encontrado</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@stop