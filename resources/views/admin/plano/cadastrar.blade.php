@extends('layouts.admin')
@section('header_title', 'Cadastrar Plano de Pagamento')

@section('js')
@parent
<script type="text/javascript" src="{{url(public_path().'ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{url(public_path().'ckfinder/ckfinder.js')}}"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function () {
    //CKFinder.setupCKEditor();
    CKEDITOR.editorConfig = function (config) {
        // Define changes to default configuration here. For example:
        // config.language = 'fr';
        // config.uiColor = '#AADC6E';
        config.filebrowserBrowseUrl = '{{url("public/kcfinder/browse.php?opener=ckeditor&type=files")}}';
        config.filebrowserImageBrowseUrl = '{{url("public/kcfinder/browse.php?opener=ckeditor&type=images")}}';
        config.filebrowserFlashBrowseUrl = '{{url("public/kcfinder/browse.php?opener=ckeditor&type=flash")}}';
        config.filebrowserUploadUrl = '{{url("public/kcfinder/upload.php?opener=ckeditor&type=files")}}';
        config.filebrowserImageUploadUrl = '{{url("public/kcfinder/upload.php?opener=ckeditor&type=images")}}';
        config.filebrowserFlashUploadUrl = '{{url("public/kcfinder/upload.php?opener=ckeditor&type=flash")}}';
        config.contentsCss = '{{url("public/css/custom.css")}}'
    };
    CKEDITOR.replace('ckeditor');
});
</script>
@stop
@section('main')
<div class="card">
    <h1>Cadastrar Plano de Pagamento</h1>
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
        <div class='col-xs-6'>
            <div class='form-group'>
                <label>Nome</label>
                <input type='text' class='form-control' name='nome' value="{{Input::old('nome')}}"/>
            </div>
            <div class='form-group'>
                <label>Quantidade Total de Documentos Fiscais</label>
                <input type='text' class='form-control numero-mask' name='total_documentos' value="{{Input::old('total_documentos')}}"/>
            </div>
            <div class='form-group'>
                <label>Quantidade Total de Documentos Contábeis</label>
                <input type='text' class='form-control numero-mask' name='total_documentos_contabeis' value="{{Input::old('total_documentos_contabeis')}}"/>
            </div>
            <div class='form-group'>
                <label>Quantidade Total de Pró-labores</label>
                <input type='text' class='form-control numero-mask' name='pro_labores' value="{{Input::old('pro_labores')}}"/>
            </div>
        </div>
        <div class='col-xs-6'>

            <div class='form-group'>
                <label>Quantidade Total de Funcionários</label>
                <input type='text' class='form-control numero-mask' name='funcionarios' value="{{Input::old('funcionarios')}}"/>
            </div>
            <div class='form-group'>
                <label>Duração</label>
                <input type='text' class='form-control' name='duracao' value="{{Input::old('duracao')}}"/>
            </div>
            <div class='form-group'>
                <label>Valor</label>
                <input type='text' class='form-control dinheiro-mask' name='valor' value="{{Input::old('valor')}}"/>
            </div>
        </div>
        <div class='col-xs-12'>
            <div class='form-group'>
                <label>Descrição</label>
                <textarea id='ckeditor'class='form-control' name='descricao'>{{Input::old('descricao')}}</textarea>
            </div>
            <div class='form-group'>
                <button type="submit" class='btn btn-success'><span class="fa fa-plus"></span> Cadastrar</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
        </div>
        <div class='clearfix'></div>
    </form>
</div>
@stop