@extends('layouts.master')
@section('header_title', 'Home')
@parent
<script type="text/javascript" src="{{url('public/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{url('public/ckfinder/ckfinder.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {
    //CKFinder.setupCKEditor();
    CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	 config.filebrowserBrowseUrl = '{{url("public/kcfinder/browse.php?opener=ckeditor&type=files")}}';
   config.filebrowserImageBrowseUrl =  '{{url("public/kcfinder/browse.php?opener=ckeditor&type=images")}}';
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
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>Planos de Pagamento</h1>
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
                <input type='text' class='form-control' name='nome' value="{{$plano->nome}}"/>
            </div>
            <div class='form-group'>
                <label>Duração</label>
                <input type='text' class='form-control' name='duracao' value="{{$plano->duracao}}"/>
            </div>
            <div class='form-group'>
                <label>Valor</label>
                <input type='text' class='form-control' name='valor' value="{{$plano->valor}}"/>
            </div>
            <div class='form-group'>
                <label>Descrição</label>
                <textarea id='ckeditor'class='form-control' name='descricao'>{{$plano->descricao}}</textarea>
            </div>
            <div class='form-group'>
                <input type='submit' value="Salvar alterações" class='btn btn-primary' />
            </div>
        </form>
    </div>
</div>
</section>
@stop