@extends('layouts.dashboard')
@section('js')
@parent
@stop
@section('main')
<h1>Início</h1>
<hr class="dash-title">
@if(Auth::user()->pessoas()->count())
<p>Selecione uma empresa abaixo para ver os impostos e os processos.</p>
<ul role="presentation" class="nav nav-tabs" role="tablist">
    @foreach(Auth::user()->pessoas()->get() as $k => $empresa)
    <li role="tab" data-toggle="tab" aria-controls="{{$empresa->cnpj}}" class="{{$k==0 ? "active" : ''}}"><a href="#">{{$empresa->nome_fantasia}}</a></li>
    @endforeach
</ul>
<div class="tab-content">
    @foreach(Auth::user()->pessoas()->get() as $k => $empresa)
    <div role="tabpanel" class="tab-pane fade in  {{$k==0?'active':''}}" id="{{$empresa->cnpj}}">
        <div class="col-xs-6">
            <p>Impostos com vencimento em <b>{{$meses[date('m')].'/'.date('Y')}}. <a href="">Mudar Data</a></b></p>
               <ul class="list-group">
            @if ($impostos->count()) 
            @foreach ($impostos as $imposto) 
                @if ($imposto->meses()->where('mes','=',((date('m')))-1)->get()->count())
                <li class="list-group-item"><a href=''>{{$imposto->nome}} - Vencimento: {{$imposto->corrigeData(date('Y') . '-' . date('m') . '-' . $imposto->vencimento)}}</a></li>
                @endif
            @endforeach
        @endif
               </ul>
        </div>
        <div class="col-xs-6">
            <p>Processos em aberto</p>
            <ul class="list-group">
                @if($empresa->processos()->count())
                @foreach($empresa->processos()->get() as $processo)
                <li class="list-group-item">
                    {{$processo->imposto->nome}} - {{$processo->competência}}
                </li>
                @endforeach
                @else
                <li class="list-group-item">
                    Nenhum processo em aberto para essa empresa
                </li>
                @endif
            </ul>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="col-xs-6">
    <p>É necessário cadastrar uma empresa</p>
</div>
@endif
@stop
@section('header_title', 'Início')
<!--@section('content')-->
<!--<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Sistema</h1>
    </div>
</section>
<section>
    <div class="container">
        @if(!Auth::user()->pessoas->count())
        <p>Você não possui nenhuma empresa cadastrada, você precisa possuir pelo menos uma empresa cadastrada para poder utilizar nosso sistema.<br />
            @endif
            <a href='{{route('cadastrar-empresa')}}'>Clique aqui para cadastrar uma empresa agora mesmo!</a></p>
        <a href='{{route('cadastrar-chamado')}}'>Abrir chamado!</a>
        <a href='{{route('listar-chamados-usuario')}}'>Visualizar chamados!</a>
        <div id="calendar"></div>
    </div>
</section>
@stop-->

