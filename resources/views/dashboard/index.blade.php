@extends('layouts.dashboard')
@section('js')
@parent
<script type="text/javascript">
    $(function () {
       $("#iframe").load(function() {
        $("#mItem11")[0].click()
        console.log('a')
    });

        $('#teste').on('submit', function (e) {
            e.preventDefault();
            $.post('{{route("ajax-simples")}}',
                    {
                        cnpj: $("[name='ctl00$ContentPlaceHolder$txtCNPJ']").val(),
                        cpf: $("[name='ctl00$ContentPlaceHolder$txtCPFResponsavel']").val(),
                        codigoAcesso: $("[name='ctl00$ContentPlaceHolder$txtCodigoAcesso']").val(),
                        cookie: $("[name='cookie']").val(),
                        viewState: $("[name='viewState']").val(),
                        input_captcha: $("[name='txtTexto_captcha']").val(),
                        eventValidation: $("[name='eventValidation']").val()
                    },
                    function (data) {
//                        $("#darf").html(data);
                    });
        });
    });
</script>
@stop
@section('main')
<h1>Início</h1>
<iframe id="iframe" width="800" height="800" src='http://www8.receita.fazenda.gov.br/SimplesNacional/controleAcesso/Autentica.aspx?id=6#form-login'></iframe>
<form id="teste">
    CNPJ:<input name="ctl00$ContentPlaceHolder$txtCNPJ" value="72477912000160" /><br />
    CPF:<input name="ctl00$ContentPlaceHolder$txtCPFResponsavel" value="53434528920"/><br />
    Código Acesso:<input name="ctl00$ContentPlaceHolder$txtCodigoAcesso" value="553522778563"/><br />
    Captcha:<input name="txtTexto_captcha" /><br />
    <input type="hidden" name="cookie" value="{{$params['cookie']}}" />
    <input type="hidden" name="viewState" value="{{$params['viewState']}}"/>
    <input type="hidden" name="eventValidation" value="{{$params['eventValidation']}}"/>
    <input type="submit" value="Continuar" name="ctl00$ContentPlaceHolder$btContinuar" /><br />
</form>
<img id="captcha-img" alt="Imagem captcha" src="{{$params['captchaBase64']}}" />
<div id="darf"></div>
<hr class="dash-title">
<div class="col-lg-7 col-md-12"><div class="hidden-lg">Olá, no calendário abaixo se encontram os impostos que você deve pagar para suas empresa.<br /> Para verificar como pagar, clique no imposto desejado.</div><br /><div id="calendar"></div></div>
<div class="col-lg-5 col-md-12" id="instrucao"><div class="visible-lg">Olá, no calendário ao lado se encontram os impostos que você deve pagar para suas empresas.<br /> Para verificar como pagar, clique no imposto desejado.</div></div>

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

