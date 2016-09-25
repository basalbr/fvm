@extends('layouts.admin')
@section('main')
<h1>F.A.Q</h1>
<hr class="dash-title">
<table class='table'>
    <thead>
        <tr>
            <th>Área do Site</th>
            <th>Pergunta</th>
            <th>Resposta</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($faqs->count())
        @foreach($faqs as $faq)
        <tr>
            <td>{{$faq->local}}</td>
            <td>{{$faq->pergunta}}</td>
            <td>{{$faq->resposta}}</td>
            <td style="width: 200px;"><a class="btn btn-warning" href="{{route('editar-faq', ['id' => $faq->id])}}">Editar</a> <a class="btn btn-danger" href="{{$faq->id}}">Remover</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2">Nenhum registro cadastrado</td>
        </tr>
        @endif
    </tbody>
</table>
<a class='btn btn-primary' href='{{route('cadastrar-faq')}}'>Cadastrar um f.a.q</a><br />

@stop