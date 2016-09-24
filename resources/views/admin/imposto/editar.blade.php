@extends('layouts.master')
@section('header_title', 'Home')
@section('js')
@parent
<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        $("#todos").on('change', function () {
            if ($(this).prop("checked")) {
                $('input[type=checkbox]').each(function () {
                    $(this).prop("checked", true);
                })
            }else{
                $('input[type=checkbox]').each(function () {
                    $(this).prop("checked", false);
                })
            }
        })
        $('input[type=checkbox]').on('change', function(){
            if($(this).prop('checked') == false){
                $('#todos').prop('checked', false);
            }
        })
    });
</script>
@stop
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Imposto</h1>
    </div>
</section>
<section>
    <div class="container">

        @if($errors->has())
        <div class="alert alert-warning shake">
            <b>Atenção</b><br />
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
            
        </div>
        @endif
        <form method="POST" action="">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Nome</label>
                <input type='text' class='form-control' name='nome' value="{{$imposto->nome}}"/>
            </div>
            <div class='form-group'>
                <label>Dia do Vencimento</label>
                <input type='text' class='form-control dia-mask' name='vencimento' value="{{$imposto->vencimento}}"/>
            </div>
            <div class='form-group'>
                <label>Mês do Vencimento</label>
                <div class="clearfix"></div>
                <input type="checkbox" id="todos" class="" {{count($imposto->meses) == 12 ? 'checked="checked"' : ''}} value="true">
                <label class="label label-primary" for="todos">Todos os meses</label>
                <br />
                @foreach($meses as $k=>$mes)
                <input type="checkbox" name="meses[]"
                       {{count($imposto->meses) == 12 ? 'checked="checked"' : ''}}  
                       {!!$imposto->meses()->where('mes','=',$k)->first() ? 'checked="checked"' : ''!!}  
                       class="" id="{{$k}}" value="{{$k}}">
                <label class="label label-primary" for="{{$k}}">{{$mes}}</label>
                <br />
                @endforeach
            </div>
            <div class='form-group'>
                <label>Antecipa ou posterga</label>
                <select class="form-control" name='antecipa_posterga'>
                    <option value="antecipa" {!! $imposto->antecipa_posterga == 'antecipa' ? 'selected="selected"' : null !!}>Antecipa</option> 
                    <option value="posterga" {!! $imposto->antecipa_posterga == 'posterga' ? 'selected="selected"' : null !!}>Posterga</option> 
                </select>
            </div>
            
            <div class='form-group'>
                <label>Receber documentos</label>
                <select class="form-control" name='recebe_documento'>
                    <option value="t" {!! $imposto->recebe_documento == true ? 'selected="selected"' : null !!}>Sim</option> 
                    <option value="f" {!! $imposto->recebe_documento == false ? 'selected="selected"' : null !!}>Não</option> 
                </select>
            </div>
             <div class='form-group'>
                <input type='submit' value="Salvar alterações" class='btn btn-primary' />
            </div>
        </form>
    </div>
</div>
</section>
@stop