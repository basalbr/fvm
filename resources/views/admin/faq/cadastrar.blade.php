@extends('layouts.master')
@section('header_title', 'Home')
@section('content')
<section id='page-header' style="margin-top: 55px" class="page-header">
    <div class='container'>
        <h1>F.A.Q</h1>
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
                <label>Área do Site</label>
                <select name="local" class="form-control">
                    <option value="site" {{Input::old('local') == 'site' ? 'selected' : ''}}>Site</option>
                    <option value="dash" {{Input::old('local') == 'dash' ? 'selected' : ''}}>Dashboard</option>
                    <option value="ambos" {{Input::old('local') == 'ambos' ? 'selected' : ''}}>Ambos</option>
                </select>
            </div>
            <div class='form-group'>
                <label>Pergunta</label>
                <input type='text' class='form-control' name='pergunta' value="{{Input::old('pergunta')}}"/>
            </div>
            <div class='form-group'>
                <label>Resposta</label>
                <textarea class='form-control' name='resposta'>{{Input::old('resposta')}}</textarea>
            </div>

            <div class='form-group'>
                <input type='submit' value="Cadastrar" class='btn btn-primary' />
            </div>
        </form>
    </div>
</div>
</section>
@stop