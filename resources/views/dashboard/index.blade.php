@extends('layouts.dashboard')
@section('js')
@parent
<script type="text/javascript">
    var planos;
    var max_documentos;
    var max_pro_labores;
    var maxValor = max_documentos;
    $(function () {
        $.get("{{route('ajax-simular-plano')}}", function (data) {
            planos = data.planos;
            max_documentos = data.max_documentos;
            max_pro_labores = data.max_pro_labores;
            maxValor = data.max_valor;
            contabilidade = parseFloat($('#contabilidade').val().replace(RegExp, "$1.$2"));
            console.log(contabilidade)
            economia = (contabilidade*12) - (parseFloat(data.min_valor) * 12); 
            $('#mensalidade').text('R$' + data.min_valor.toFixed(2));
            $('#economia').text('R$' + economia.toFixed(2));
        });
        $('#total_documentos, #contabilidade, #pro_labores').on('keyup', function () {

            var minValor = maxValor;
            if ($('#pro_labores').val() > max_pro_labores) {
                $('#pro_labores').val(max_pro_labores);
            }
            if ($('#total_documentos').val() > max_documentos) {
                $('#total_documentos').val(max_documentos);
            }
            for (i in planos) {

                if ($('#total_documentos').val() <= planos[i].total_documentos && $('#pro_labores').val() <= planos[i].pro_labores && planos[i].valor < minValor) {
                    minValor = parseFloat(planos[i].valor);
                }
            }
            $('#mensalidade').text('R$' + minValor.toFixed(2));
            var RegExp = /^([\d]+)[,.]([\d]{2})$/;
            contabilidade = $('#contabilidade').val().replace(".", "");
            contabilidade = parseFloat(contabilidade.replace(",","."));
            totalDesconto = (contabilidade*12)-(minValor * 12) > 0 ? (contabilidade*12)-(minValor * 12) : 0;
            $('#economia').html('R$' + totalDesconto.toFixed(2));
        });

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
<div class='col-xs-8'>
    <div class='card'>
        <h3>Simulação de Mensalidade</h3> 

        <p>Complete os campos abaixo e confira os valores de nossas mensalidades. <b>Atenção:</b> valor individual por empresa cadastrada no sistema.</p>
        <div class='col-xs-6'>
            <form>
                <div class='form-group'>
                    <label>Quantos sócios retiram pró-labore?</label>
                    <input type='text' class='form-control numero-mask2' id='pro_labores' data-mask-placeholder='0' />
                </div>
                <div class='form-group'>
                    <label>Quantos documentos fiscais são emitidos por mês?</label>
                    <input type='text' class='form-control numero-mask2' id='total_documentos' data-mask-placeholder='0'/>
                </div>
                <div class='form-group'>
                    <label>Quanto você paga hoje por mês para sua contabilidade?</label>
                    <input type='text' class='form-control dinheiro-mask2' id='contabilidade' data-mask-placeholder='0' value="499,99"/>
                </div>
                <a class='btn btn-success' href='{{route('cadastrar-empresa')}}'>Cadastrar Empresa</a>
            </form>
        </div>
        <div class='col-xs-6'>
            <h2 class='text-center'>Sua mensalidade será:</h2>
            <div id='mensalidade' class='text-center text-info' style="font-size:45px; font-weight: bold;">R$0,00</div>
            <h2 class='text-center'>Você <b>economizará</b> por ano:</h2>
            <div id='economia' class='text-center text-success' style="font-size:45px; font-weight: bold;">R$0,00</div>
        </div>
        <div class='clearfix'></div>
    </div>
</div>


<div class='col-xs-4'>
    <div class='card'>
        <h3>Impostos de {{$meses[date('m')]}}</h3> 

        <p>Clique em um imposto para visualizar mais informações</p>
        <ul class='lista-apuracoes-urgentes'>
            @foreach($impostos as $imposto)
            <li>
                <a href="{{route('responder-processo-usuario', ['id' => $imposto->id])}}">
                    <div class='empresa'>{{$imposto->nome}}</div>
                    <div class='imposto'>{{$imposto->vencimento.'/'.$meses[date('m')]}}</div>
                </a>
            </li>
            @endforeach
        </ul>
        <a class="btn btn-info" href="{{route('calendario')}}">Visualizar calendário de impostos</a>
    </div>
</div>
@stop