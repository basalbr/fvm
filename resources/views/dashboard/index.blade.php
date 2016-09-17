@extends('layouts.dashboard')

@section('main')
<h1>Central do Cliente</h1>
<p>Seja bem vindo {{Auth::user()->nome}}, utilize os botões no menu esquerdo para navegar em nosso sistema.</p>
<hr class="dash-title">

@if(count($apuracoes)>0)
<div class='col-xs-7'>
    <div class='card'>
        <h3>Apurações em aberto</h3>
        <p>Você possui algumas apurações que precisam de informações adicionais.</p>
        <ul class='lista-apuracoes-urgentes'>
            @foreach($apuracoes as $apuracao)
            <li>
                <a href="{{route('responder-processo-usuario', ['id' => $apuracao->id])}}">
                    <div class='empresa'>{{$apuracao->pessoa->nome_fantasia}}</div>
                    <div class='imposto'>{{$apuracao->imposto->nome}}<span class="btn btn-info pull-right">Visualizar</span></div>
                    <div class='vencimento'>Vencimento: {{$apuracao->vencimento_formatado()}}</div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class='col-xs-5'>
    <div class='card'>
        <h3>Empresas cadastradas</h3> 

        @if($empresas->count())
        <p>Clique em uma empresa para visualizar informações</p>
        <ul class="list-group">
            @foreach($empresas as $empresa)
            <li class="list-group-item">{{$empresa->nome_fantasia}}</li>
            @endforeach
        </ul>
        <a class="btn btn-info" href="{{route('empresas')}}">Visualizar todas as empresas</a>
        @else
        <p>Você não possui nenhuma empresa cadastrada, para utilizar nosso sistema e aproveitar nossos serviços, você precisa cadastrar pelo menos uma empresa.<br/><a href="{{route('cadastrar-pessoa')}}" >Clique aqui para cadastrar uma empresa.</a></p>
        @endif
    </div>
</div>

<div class='col-xs-7'>
    <div class='card'>
        <h3>Últimas mensagens</h3> 

        @if($mensagens->count())
        <p>Clique em uma mensagem para abrir a conversa.</p>
        <ul class="list-group">
            @foreach($mensagens as $mensagem)
            <li class="list-group-item"><a href="{{route('responder-chamado-usuario')}}">{{$empresa->nome_fantasia}} - {{date_format($mensagem->created_at, 'H:i d/m/y')}}</a></li>
            @endforeach
        </ul>
        <a class="btn btn-info" href="{{route('chamados')}}">Visualizar todas as mensagens</a>
        @else
        <p>Você não possui nenhuma mensagem.</p>
        @endif
    </div>
</div>
@stop