@extends('layouts.dashboard')
@section('header_title', 'Mensalidades')
@section('main')

<div class="card">
    <h1>Histórico de Pagamentos</h1>
        <p>Abaixo estão as ordens de pagamento realizados no nosso sistema.</p>

    <h3>Lista de Pagamentos Realizados</h3>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Valor</th>
                <th>Vencimento</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if($pagamentos->count())
            @foreach($pagamentos as $pagamento)
            <tr>
                <td>{{$pagamento->mensalidade->empresa->nome_fantasia}}</td>
                <td>R$ {{number_format($pagamento->mensalidade->valor,2,',','.')}}</td>
                <td>{{DateTime::createFromFormat('Y-m-d H:i:s', $pagamento->vencimento)->format('d/m/Y')}}</td>
                <td><b>{{$pagamento->status}}</b></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5">Nenhuma ordem de pagamento em aberto.</td>
            </tr>
            @endif
        </tbody>
    </table>
    {!! str_replace('/?', '?', $pagamentos->render()) !!}
    <div class="clear"></div>
</div>

@stop