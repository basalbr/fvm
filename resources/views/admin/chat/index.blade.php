@extends('layouts.admin')
@section('header_title', 'Chamados')
@section('js')
@parent
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
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
@section('main')
<h1>Chat</h1>
<hr class="dash-title">
<div class="card">
    <h3>Filtros de Pesquisa</h3>
    <form class="form-inline">
        <div class="form-group" style="width: 300px">
            <label>Nome</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='nome' value='{{Input::get('nome')}}'/>
        </div>
         <div class="form-group" style="width: 300px">
            <label>E-mail</label>
            <div class="clearfix"></div>
            <input type="text" class="form-control" name='email' value='{{Input::get('email')}}'/>
        </div>
        <div class="form-group" style="width: 110px">
            <label>De</label>
            <input type="text" class="form-control date-mask" name='de' value='{{Input::get('de')}}'/>
        </div>
        <div class="form-group" style="width: 110px">
            <label>Até</label>
            <input type="text" class="form-control date-mask" name='ate' value='{{Input::get('ate')}}'/>
        </div>
        <div class="form-group" style="width: 250px">
            <label>Ordenar por</label>
            <select name="ordenar" class="form-control">
                <option value="atualizado_desc" {{Input::get('ordenar') == 'atualizado_desc' ? 'selected' : ''}}>Mais recente</option>
                <option value="atualizado_asc" {{Input::get('ordenar') == 'atualizado_asc' ? 'selected' : ''}}>Mais antigo</option>
                <option value="titulo_asc" {{Input::get('ordenar') == 'titulo_asc' ? 'selected' : ''}}>Título - A/Z</option>
                <option value="titulo_desc" {{Input::get('ordenar') == 'titulo_desc' ? 'selected' : ''}}>Título - Z/A</option>
            </select>
        </div>
        <div class="form-group"  style="width: 50px">
            <label>&zwnj;</label>
            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Pesquisar</button>
        </div>
        <div class="clearfix"></div>
    </form>
    <br />
    <h3>Lista de chats</h3>
    <div class=" table-responsive">
        <table class='table table-hover'>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Última Mensagem</th>
                    <th>Enviado em</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($chats->count())
                @foreach($chats as $chat)
                <tr>
                    <td>{{$chat->nome}}</td>
                    <td>{{$chat->email}}</td>
                    <td>{{!empty($chat->mensagens()->orderBy('created_at')->first()) ? str_limit($chat->mensagens()->orderBy('created_at')->first()->mensagem, 50) : str_limit($chat->mensagem,50)}}</td>
                    <td>{{date_format($chat->created_at, 'd/m/Y - H:i:s')}}</td>
                    <td><a href="{{route('visualizar-chat', ['id' => $chat->id])}}" class="btn btn-primary">Visualizar</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">Nenhum registro cadastrado</td>
                </tr>
                @endif
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
    {!! str_replace('/?', '?', $chats->render()) !!}
    <!--@include('pagination.default', ['paginator' => $chats])-->
    <div class="clearfix"></div>
</div>
@stop