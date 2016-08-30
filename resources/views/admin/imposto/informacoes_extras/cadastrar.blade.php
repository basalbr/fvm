@extends('layouts.admin')
@section('js')
@parent
<script type='text/javascript'>
    $(function () {
        $('select[name="tipo"]').on('change', function () {
            $('.anexo').addClass('hidden').find('input').prop('disabled', true);
            $('.dado-integrado').addClass('hidden').find('input').prop('disabled', true);
            if ($(this).val() == 'anexo') {
                $('.anexo').removeClass('hidden').find('input').prop('disabled', false);
            }
            if ($(this).val() == 'dado_integrado') {
                $('.dado-integrado').removeClass('hidden').find('input').prop('disabled', false);
            }
        })
    });
</script>
@stop
@section('main')
<h1>Cadastrar Informação Extra</h1>
<hr class="dash-title">

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
        <label>Tipo</label>
        <select name="tipo" class='form-control'>
            <option value="" selected="">Selecione uma opção</option>
            <option value="anexo">Anexo</option>
            <option value="dado_integrado">Dado Integrado</option>
            <option value="informacao_adicional">Informação Adicional</option>
        </select>
    </div>
    <div class='form-group'>
        <label>Nome</label>
        <input type='text' class='form-control' name='nome' value="{{Input::old('nome')}}"/>
    </div>
    <div class='form-group'>
        <label>Descrição</label>
        <textarea class='form-control' name='descricao'>{{Input::old('descricao')}}</textarea>
    </div>
    <div class='form-group anexo hidden'>
        <label>Tamanho Máximo do Arquivo (KBs)</label>
        <input type='text' disabled="disabled" class='form-control' name='tamanho_maximo' max="9999" value="{{Input::old('tamanho_maximo')}}"/>
    </div>
    <div class='form-group anexo hidden'>
        <label>Selecione as extensões permitidas</label>
        <br />
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="doc"/> DOC
        </label>
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="docx"/> DOCX
        </label>
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="gif"/> GIF
        </label>
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="jpg"/> JPG
        </label>
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="pdf"/> PDF
        </label>
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="png"/> PNG
        </label>
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="txt"/> TXT
        </label>
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="xls"/> XLS
        </label>
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="xlsx"/> XLSX
        </label>
        <label>
            <input disabled="disabled" type='checkbox' name='extensao[]' value="xml"/> XML
        </label>
    </div>
    <div class='form-group dado-integrado hidden'>
        <label>Tabela</label>
        <input type='text' disabled="disabled" class='form-control' name='tabela' value="{{Input::old('tabela')}}"/>
    </div>
    <div class='form-group dado-integrado hidden'>
        <label>Campo</label>
        <input type='text' disabled="disabled" class='form-control' name='campo' value="{{Input::old('campo')}}"/>
    </div>
    <div class='form-group'>
        <input type='submit' value="Cadastrar" class='btn btn-primary' />
    </div>
</form>
@stop