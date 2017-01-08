@extends('layouts.admin')
@section('header_title', 'Home')
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
    <h1>F.A.Q</h1>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <form method="POST" action="">
        <h3>Informações</h3>
        <div class="col-xs-12">
            {{ csrf_field() }}
            <div class='form-group'>
                <label>Área do Site</label>
                <select name="local" class="form-control">
                    <option value="site" {{$faq->local == 'site' ? 'selected' : ''}}>Site</option>
                    <option value="dash" {{$faq->local == 'dash' ? 'selected' : ''}}>Dashboard</option>
                    <option value="ambos" {{$faq->local == 'ambos' ? 'selected' : ''}}>Ambos</option>
                </select>
            </div>
            <div class='form-group'>
                <label>Pergunta</label>
                <input type='text' class='form-control' name='pergunta' value="{{$faq->pergunta}}"/>
            </div>
            <div class='form-group'>
                <label>Resposta</label>
                <textarea id='ckeditor' class='form-control' name='resposta'>{{$faq->resposta}}</textarea>
            </div>

          <div class='form-group'>
                <button type="submit" class='btn btn-success'><span class="fa fa-save"></span> Salvar Alterações</button>
                <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
            </div>
            </div>
        </form>
    
    <div class="clearfix"></div>
</div>
@stop