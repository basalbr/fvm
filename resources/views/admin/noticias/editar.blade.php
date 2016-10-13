@extends('layouts.admin')
@section('header_title', 'Home')
@section('js')
@parent
<script type="text/javascript" src="{{url('public/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{url('public/ckfinder/ckfinder.js')}}"></script>
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function () {
    $('.date-mask').on('keypress', function () {
        return false;
    });
    $('.date-mask').datepicker({
        language: 'pt-BR',
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayBtn: 'linked'
    });
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
<h1>Cadastrar Notícia</h1>
<hr class="dash-title">

@if($errors->has())
<div class="alert alert-warning shake">
    <b>Atenção</b><br />
    @foreach ($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
</div>
@endif
<form method="POST" action=""  enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class='form-group'>
        <label>Título</label>
        <input type='text' class='form-control' name='titulo' value="{{$noticia->titulo}}"/>
    </div>
    <div class='form-group'>
        <label>Texto</label>
        <textarea id='ckeditor' class='form-control' name='texto'>{{$noticia->texto}}</textarea>
    </div>
    <div class='form-group'>
        <label>Imagem (Deixe em branco para não alterar)</label>
        <div class='input-group col-md-12'>
            <input type='file' class='form-control' value="" name='imagem'/>
        </div>
    </div>
    <div class="form-group">
        <label>Data de Publicação</label>
        <input type="text" class="form-control date-mask" name='created_at' value='{{$noticia->created_at->format('d/m/Y')}}'/>
    </div>
    <div class='form-group'>
        <input type='submit' value="Alterar Notícia" class='btn btn-primary' />
    </div>
</form>
@stop