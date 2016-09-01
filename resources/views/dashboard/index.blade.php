@extends('layouts.dashboard')
@section('js')
@parent
<script type="text/javascript">
    $(function () {
       
    });
</script>
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
    <div role="tabpanel" class="tab-pane fade in  {{$k==0?'active':''}}" id="{{$empresa->cpf_cnpj}}">
        <div class="col-xs-6">
            <p class='dash-info'><span class='fa fa-dollar'></span> Obrigações com vencimento em <b>{{$meses[date('m')].'/'.date('Y')}}</b>. Clique em uma das obrigações para abrir um processo de apuração.</p>
            <a class='btn btn-primary' href="">Mudar Data</a>
            <hr>
            <form method="GET" action="{{route('abrir-processo')}}" id="processo-form">
                {{csrf_field()}}
                <input type="hidden" name="competencia">
                <input type="hidden" name="id_imposto">
                <input type="hidden" name="cnpj" value="{{$empresa->cpf_cnpj}}">
                <input type="hidden" name="vencimento">
                <ul class="list-group lista-impostos">
                    @if ($impostos->count()) 
                    @foreach ($impostos as $imposto) 
                    @if ($imposto->meses()->where('mes','=',((date('m')))-1)->get()->count())
                    
                    <li class="list-group-item" >
                        <a class="btn-block" href="{{route('abrir-processo',['competencia'=>(date('m')-1).'-'.date('Y'), 'id_imposto'=>$imposto->id, 'cnpj'=>$empresa->cpf_cnpj,'vencimento'=>$imposto->corrigeData(date('Y') . '-' . date('m') . '-' . $imposto->vencimento, 'd-m-Y')])}}"><b>Dia {{$imposto->corrigeData(date('Y') . '-' . date('m') . '-' . $imposto->vencimento, 'd')}}</b> - <i>{{$imposto->nome}}</i></a>
                    </li>
                    @endif
                    @endforeach
                    @endif
                </ul>
            </form>
        </div>
        <div class="col-xs-6">
            <p class='dash-info'><span class='fa fa-file-o'></span> Processos em aberto</p>
            <hr>
            <ul class="list-group lista-processos">
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
        <div class='clearfix'></div>
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
@section('modal')
<div class="modal fade" id="imposto-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Abrir processo para <span id='nome-imposto'></span></h4>
            </div>
            <div class="modal-body">
                <p>Por favor, confirme os dados abaixo e se estiverem corretos, clique em abrir processo.</p>
                <form id="imposto-form">
                    <div class='form-group'>
                        <label>Empresa</label>
                        <div class='input-group col-md-12'>
                            <input type='text' id="empresa" class='form-control' disabled=""/>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label>CNPJ</label>
                        <div class='input-group col-md-12'>
                            <input type='text' id="cnpj" class='form-control cnpj-mask' disabled=""/>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label>Imposto</label>
                        <div class='input-group col-md-12'>
                            <input type='text' id="imposto" class='form-control' disabled=""/>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label>Competência</label>
                        <div class='input-group col-md-12'>
                            <input type='text' id="competencia" class='form-control' disabled=""/>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label>Data de Vencimento</label>
                        <div class='input-group col-md-12'>
                            <input type='text' id="data-vencimento" class='form-control' disabled=""/>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label>Anexo</label>
                        <div class='input-group col-md-12'>
                            <input type='text' id="anexo" class='form-control' disabled=""/>
                        </div>
                    </div>
                    <input type='hidden' id="id_imposto" class='form-control'/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Abrir Processo</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop
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

