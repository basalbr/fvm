@extends('layouts.admin')

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
    <input type='hidden' class='form-control' name='tipo' value="{{$informacao_extra->tipo}}"/>
    <div class='form-group'>
        <label>Tipo</label>
        <input type='text' class='form-control' disabled="" value="{{$informacao_extra->tipo_formatado()}}"/>
    </div>
    <div class='form-group'>
        <label>Nome</label>
        <input type='text' class='form-control' name='nome' value="{{$informacao_extra->nome}}"/>
    </div>
    <div class='form-group'>
        <label>Descrição</label>
        <textarea class='form-control' name='descricao'>{{$informacao_extra->descricao}}</textarea>
    </div>
    @if($informacao_extra->tipo == 'anexo')
    <div class='form-group'>
        <label>Tamanho Máximo do Arquivo (KBs)</label>
        <input type='text'  class='form-control' name='tamanho_maximo' max="9999" value="{{$informacao_extra->tamanho_maximo}}"/>
    </div>
    <div class='form-group'>
        <label>Selecione as extensões permitidas</label>
        <br />
        <label>
            <input type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','doc')->first())>0 ? 'checked="checked"' : ''}} value="doc"/> DOC
        </label>
        <label>
            <input  type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','docx')->first())>0 ? 'checked="checked"' : ''}} value="docx"/> DOCX
        </label>
        <label>
            <input  type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','gif')->first())>0 ? 'checked="checked"' : ''}} value="gif"/> GIF
        </label>
        <label>
            <input type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','jpg')->first())>0 ? 'checked="checked"' : ''}} value="jpg"/> JPG
        </label>
        <label>
            <input  type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','pdf')->first())>0 ? 'checked="checked"' : ''}} value="pdf"/> PDF
        </label>
        <label>
            <input  type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','png')->first())>0 ? 'checked="checked"' : ''}} value="png"/> PNG
        </label>
        <label>
            <input  type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','txt')->first())>0 ? 'checked="checked"' : ''}} value="txt"/> TXT
        </label>
        <label>
            <input  type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','xls')->first())>0 ? 'checked="checked"' : ''}} value="xls"/> XLS
        </label>
        <label>
            <input  type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','xlsx')->first())>0 ? 'checked="checked"' : ''}} value="xlsx"/> XLSX
        </label>
        <label>
            <input  type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','xml')->first())>0 ? 'checked="checked"' : ''}} value="xml"/> XML
        </label>
        <label>
            <input  type='checkbox' name='extensao[]' {{count($informacao_extra->extensoes()->where('extensao','=','zip')->first())>0 ? 'checked="checked"' : ''}} value="zip"/> ZIP
        </label>
    </div>
    @endif
    @if($informacao_extra->tipo == 'dado_integrado')
    <div class='form-group'>
        <label>Tabela</label>
        <input type='text'  class='form-control' name='tabela' value="{{$informacao_extra->tabela}}"/>
    </div>
    <div class='form-group'>
        <label>Campo</label>
        <input type='text'  class='form-control' name='campo' value="{{$informacao_extra->campo}}"/>
    </div>
    @endif
    <div class='form-group'>
        <input type='submit' value="Salvar" class='btn btn-primary' />
    </div>
</form>
@stop