@extends('layouts.dashboard')
@section('header_title', $processo->imposto->nome .' - Competência: '. date_format(date_create($processo->competencia), 'm/Y'))
@section('main')

    <div class="card">
        <h1>Visualizar Processo</h1>
        @if($errors->has())
            <div class="alert alert-warning shake">
                <b>Atenção</b><br/>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br/>
                @endforeach
            </div>
        @endif
        <h3>{{$processo->imposto->nome}} - {{date_format(date_create($processo->competencia), 'm/Y')}}</h3>
        <div class="processo-info">
            <blockquote>
                <h4>Informações da apuração</h4>
                <div class="pull-left">
                    <div class="titulo">Status do Processo</div>
                    @if($processo->status == 'novo' || $processo->status == 'aberto')
                        <div class='text-info info'>Aberto</div>
                    @elseif($processo->status == 'atencao')
                        <div class='text-danger info'>Atenção</div>
                    @elseif($processo->status == 'cancelado')
                        <div class='text-muted info'>Cancelado</div>
                    @elseif($processo->status == 'concluido')
                        <div class='text-success info'>Concluído</div>
                    @endif
                </div>
                <div class="pull-left">
                    <div class="titulo">Imposto</div>
                    <div class="info">{{$processo->imposto->nome}}</div>
                </div>
                <div class="pull-left">
                    <div class="titulo">Competência</div>
                    <div class="info">{{date_format(date_create($processo->competencia), 'm/Y')}}</div>
                </div>
                <div class="pull-left">
                    <div class="titulo">Data de Vencimento</div>
                    <div class="info">{{date_format(date_create($processo->vencimento), 'd/m/Y')}}</div>
                </div>
                <div class="clearfix"></div>
                <hr class="dash-title">
                <h4>Informações da empresa</h4>
                <div class="pull-left">
                    <div class="titulo">Nome Fantasia</div>
                    <div class="info">{{$processo->pessoa->nome_fantasia}}</div>
                </div>
                <div class="pull-left">
                    <div class="titulo">Razão Social</div>
                    <div class="info">{{$processo->pessoa->razao_social}}</div>
                </div>
                <div class="pull-left">
                    <div class="titulo">CNPJ</div>
                    <div class="info">{{$processo->pessoa->cpf_cnpj}}</div>
                </div>
                @if($processo->informacoes_extras()->count())
                    <div class="clearfix"></div>
                    <hr class="dash-title">
                    <h4>Informações enviadas pelo usuário</h4>
                    <div class="clearfix"></div>
                    @foreach($processo->informacoes_extras as $informacao_extra)
                        <div class="pull-left">
                            <div class="titulo">{{$informacao_extra->informacao_extra->nome}}</div>
                            @if($informacao_extra->informacao_extra->tipo=='informacao_adicional')
                                <div class="info">{{$informacao_extra->informacao}}</div>
                            @endif
                            @if($informacao_extra->informacao_extra->tipo=='anexo')
                                <div class="info"><a download
                                                     href='{{asset('/uploads/processos/'.$informacao_extra->informacao)}}'
                                                     target="_blank">Download</a></div>
                            @endif
                        </div>
                    @endforeach
                @endif
                @if($processo->guia)
                    <div class="clearfix"></div>
                    <h4>Download da guia do processo</h4>
                    <div class="clearfix"></div>
                    <div class="pull-left">
                        <div class="titulo">Guia do Processo</div>
                        <div class="info"><a download href='{{asset('/uploads/guias/'.$processo->guia)}}'
                                             target="_blank">Download</a></div>
                    </div>
                @endif
                <div class="clearfix"></div>
            </blockquote>
        </div>
        @if($processo->imposto->informacoes_extras()->count() && !$processo->informacoes_extras()->count())
            <form method="POST" action="{{route('enviar-informacoes-processo',[$processo->id])}}"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <br/>
                <h3>Informações adicionais</h3>
                <p>{{Auth::user()->nome}}, é necessário enviar algumas informações adicionais para que possamos dar
                    continuidade no processo de apuração.<br/>Abaixo estão as informações adicionais de que precisamos.
                </p>

                <div class="col-xs-12">
                    @foreach($processo->imposto->informacoes_extras()->orderBy('tipo')->orderBy('nome')->get() as $informacao_extra)
                        @if($informacao_extra->tipo == 'anexo')
                            <div class='form-group'>
                                <label>{{$informacao_extra->nome}}</label>

                                @if($informacao_extra->descricao)
                                    <p><i>{{$informacao_extra->descricao}}</i></p>
                                @endif
                                <p>Tipos de arquivo que você pode enviar: {{$informacao_extra->tamanho_maximo}}KBs<br/>Extensões
                                    válidas: @foreach($informacao_extra->extensoes as $extensao) {!!'<span class="label label-primary">'.$extensao->extensao.'</span>'!!} @endforeach
                                </p>
                                <div class='input-group col-md-12'>
                                    <input type='file' class='form-control' value=""
                                           name='anexo[{{$informacao_extra->id}}]'/>
                                </div>
                            </div>
                        @endif
                        @if($informacao_extra->tipo == 'informacao_adicional')
                            <div class='form-group'>
                                <label>{{$informacao_extra->nome}}</label>
                                @if($informacao_extra->descricao)
                                    <p><i>{{$informacao_extra->descricao}}</i></p>
                                @endif
                                <div class='input-group col-md-12'>
                                    <input type='text' class='form-control'
                                           name="informacao_adicional[{{$informacao_extra->id}}]"/>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div class='form-group'>
                        <input type='submit' value="Enviar Informações" class='btn btn-primary'/>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
        @endif
        <form method="POST" action="">
            <br/>
            <h3>Mensagens</h3>
            <p>Caso esteja com dúvidas com relação a essa apuração, você pode nos enviar uma mensagem pelo formulário
                abaixo.</p>
            {{ csrf_field() }}
            <div class="col-xs-12">
                <div class='form-group'>
                    <label>Nova Mensagem</label>
                    <textarea class="form-control" name='mensagem' required=""></textarea>
                </div>
                @if($processo->status == 'atencao')
                    <div class='form-group'>
                        <label>Anexar arquivo</label>
                        <input type='file' class='form-control' value="" name='anexo'/>
                    </div>
                @endif
                <div class='form-group'>
                    <button type='submit' class='btn btn-success'><span class='fa fa-send'></span> Enviar Mensagem
                    </button>
                    <a href="{{URL::previous()}}" class="btn btn-primary"><span class='fa fa-history'></span> Voltar</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
        @if($processo->processo_respostas->count())
            <br/>
            <h3>Últimas mensagens:</h3>
            @foreach($processo->processo_respostas()->orderBy('updated_at', 'desc')->get() as $resposta)
                <div class='form-group'>

                    <div class="mensagem {{$resposta->usuario->id == Auth::user()->id ? 'mensagem-usuario':'mensagem-admin'}}">
                        <p class='title'>{{$resposta->usuario->nome}} em {{date_format($resposta->updated_at, 'd/m/Y')}}
                            às {{date_format($resposta->updated_at, 'H:i')}}</p>
                        {{$resposta->mensagem}}
                    </div>
                </div>
                <div class="clearfix"></div>
            @endforeach
        @endif
    </div>
@stop