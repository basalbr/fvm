@extends('layouts.admin')
@section('header_title', 'Abertura de Empresa')
@section('js')
@parent
<script type="text/javascript">
    $(function () {
        $('#show-info').on('click', function (e) {
            e.preventDefault();
            $('#info-modal').modal('show');
        });
    });
</script>
@stop
@section('main')

<div class="card">
    <h1>Processo de abertura de empresa</h1>
    <div class="processo-info">
        <h3>Processo de Abertura de Empresa</h3>
        <blockquote>
            <div class="pull-left">
                <div class="titulo">Status do Processo</div>
                <div class='text-success info'>{{$empresa->status}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Status do Pagamento</div>
                <div class='text-success info'>{{$empresa->pagamento->status}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Nome Preferencial</div>
                <div class="info">{{$empresa->nome_empresarial1}}</div>
            </div>
            <div class="pull-left">
                <div class="titulo">Nome do Sócio Principal</div>
                <div class="info">{{$empresa->socios()->where('principal','=',1)->first()->nome}}</div>
            </div>
            <div class='clearfix'></div>
            <div class="pull-left">
                <div class="titulo"></div>
                <div class="info"><a href='' id="show-info">Clique aqui para ver todas as informações</a></div>
            </div>
            <div class='clearfix'></div>
        </blockquote>

    </div>
    @if($errors->has())
    <div class="alert alert-warning shake">
        <b>Atenção</b><br />
        @foreach ($errors->all() as $error)
        {{ $error }}<br />
        @endforeach
    </div>
    @endif
    <form method="POST" action="" enctype="multipart/form-data">
        <h3>Nova Mensagem</h3>
        <div class='col-xs-12'>
            {{ csrf_field() }}

            <div class='form-group'>
                <label>Status</label>
                <select class='form-control' name='status'>
                    <option {{$empresa->status == 'Novo' ? 'selected' : ''}} value="Novo">Novo</option>
                    <option {{$empresa->status == 'Atenção' ? 'selected' : ''}} value="Atenção">Atenção</option>
                    <option {{$empresa->status == 'Em Processamento' ? 'selected' : ''}} value="Em Processamento">Em Processamento</option>
                    <option {{$empresa->status == 'Cancelado' ? 'selected' : ''}} value="Cancelado">Cancelado</option>
                    <option {{$empresa->status == 'Concluído' ? 'selected' : ''}} value="Concluído">Concluído</option>
                </select>
            </div>
            <div class='form-group'>
                <label>Anexar arquivo</label>
                <input type='file' class='form-control' value="" name='anexo'/>
            </div>
            <label>Mensagem</label>
            <div class='form-group'>
                <textarea class="form-control" name='mensagem'></textarea>
            </div>
            <div class='form-group'>
                <input type='submit' value="Enviar mensagem" class='btn btn-primary' />
                <a href="{{route('cadastrar-abertura-empresa-admin',[$empresa->id])}}"class='btn btn-success'>Cadastrar nova empresa</a>
            </div>
        </div>
        <div class='clearfix'></div>
    </form>

    <h3>Últimas mensagens:</h3>
    <div class='col-xs-12'>
        @if($empresa->mensagens->count())
        @foreach($empresa->mensagens()->orderBy('updated_at', 'desc')->get() as $resposta)
        <div class='form-group'>
            <div class="mensagem {{$resposta->usuario->id == Auth::user()->id ? 'mensagem-usuario':'mensagem-admin'}}">
                <p class='title'>{{$resposta->usuario->nome}} em {{date_format($resposta->updated_at, 'd/m/Y')}} às {{date_format($resposta->updated_at, 'H:i')}}</p>
                {{$resposta->mensagem}}
                @if($resposta->anexo)
                <div class="anexo"><span class="fa fa-file-o"></span> <a download href='{{asset('/uploads/abertura_empresa/'.$resposta->anexo)}}' target="_blank">Anexo</a></div>
                @endif
            </div>
        </div>
        @endforeach
        @else
        <p>Nenhuma mensagem encontrada</p>
        @endif
    </div>
    <div class="clearfix"></div>

</div>
@stop

@section('modal')
<div class="modal fade" id="info-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"  style="width: 1000px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Informações do Processo</h4>
                <div class="clearfix"></div>
            </div>
            <div class="modal-body">
                <p>Escolha um item abaixo para visualizar as informações</p>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#pane-empresa" aria-controls="pane-empresa" role="tab" data-toggle="tab">Empresa</a></li>
                    <li role="presentation"><a href="#pane-endereco" aria-controls="pane-endereco" role="tab" data-toggle="tab">Endereço</a></li>
                    <li role="presentation"><a href="#pane-socios" aria-controls="pane-socios" role="tab" data-toggle="tab">Sócios</a></li>
                    <li role="presentation"><a href="#pane-cnae" aria-controls="pane-cnae" role="tab" data-toggle="tab">CNAE</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="pane-empresa">
                        <br />
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Nome Empresarial Preferencial</label>
                                <input type='text' class='form-control' value="{{$empresa->nome_empresarial1}}"/>
                            </div>
                            <div class='form-group'>
                                <label>Nome Empresarial Alternativo 1</label>
                                <input type='text' class='form-control' value="{{$empresa->nome_empresarial2}}"/>
                            </div>
                            <div class='form-group'>
                                <label>Nome Empresarial Alternativo 2</label>
                                <input type='text' class='form-control' value="{{$empresa->nome_empresarial3}}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class='form-group'>
                                <label>Natureza Jurídica</label>
                                <input type='text' class='form-control' value='{{$empresa->natureza_juridica->descricao}}' />
                            </div>
                            <div class='form-group'>
                                <label>Enquadramento da empresa</label>
                                <input type='text' class='form-control' value='{{$empresa->enquadramento}}' />
                            </div>
                            <div class='form-group'>
                                <label>Capital Social</label>
                                <textarea class='form-control' >{{$empresa->capital_social}}</textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pane-endereco">
                        <br />
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>CEP</label>
                                <input type='text' class='form-control' value="{{$empresa->capital_social}}" />
                            </div>
                            <div class='form-group'>
                                <label>Estado *</label>
                                <input type='text' class='form-control' value="{{$empresa->uf->nome}}"/>
                            </div>
                            <div class='form-group'>
                                <label>Cidade *</label>
                                <input type='text' class='form-control' value="{{$empresa->cidade}}"/>
                            </div>
                            <div class='form-group'>
                                <label>Endereço *</label>
                                <input type='text' class='form-control' value="{{$empresa->endereco}}"/>
                            </div>
                            <div class='form-group'>
                                <label>Bairro *</label>
                                <input type='text' class='form-control' value="{{$empresa->bairro}}"/>
                            </div>
                            <div class='form-group'>
                                <label>Número *</label>
                                <input type='text' class='form-control' value="{{$empresa->numero}}"/>
                            </div>

                        </div>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Complemento</label>
                                <input type='text' class='form-control' value="{{$empresa->complemento}}"/>
                            </div>
                            <div class='form-group'>
                                <label>Inscrição IPTU *</label>
                                <input type='text' class='form-control' value="{{$empresa->iptu}}"/>
                            </div>
                            <div class='form-group'>
                                <label>Área total ocupada em m² *</label>
                                <input type='text' class='form-control' value="{{$empresa->area_ocupada}}"/>
                            </div>
                            <div class='form-group'>
                                <label>Área total do imóvel m² *</label>
                                <input type='text' class='form-control' value="{{$empresa->area_total}}"/>
                            </div>
                            <div class='form-group'>
                                <label>CPF ou CNPJ do proprietário do imóvel *</label>
                                <input type='text' class='form-control' value="{{$empresa->cpf_cnpj_proprietario}}"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pane-socios">
                        <div class='col-xs-12'>
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach($empresa->socios as $k => $socio)

                                <li role="presentation" class="{{$k == 0 ? 'active':''}}"><a href="#socio-{{$k}}" aria-controls="socio-{{$k}}" role="tab" data-toggle="tab">{{$socio->nome}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class='clearfix'></div>
                        <br />
                        @foreach($empresa->socios as $k => $socio)
                        <div role="tabpanel" class="tab-pane" id="socio-{{$k}}">
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Principal?</label>
                                    <input type='text' class='form-control' value="{{$socio->principal ? 'Sim' : 'Não' }}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Nome</label>
                                    <input type='text' class='form-control' value="{{$socio->nome}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Nome da mãe</label>
                                    <input type='text' class='form-control' value="{{$socio->nome_mae}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Nome do pai</label>
                                    <input type='text' class='form-control' value="{{$socio->nome_pai}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Data de nascimento</label>
                                    <input type='text' class='form-control' value="{{$socio->data_nascimento->format('d/m/Y')}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Estado civil</label>
                                    <input type='text' class='form-control' value="{{$socio->estado_civil}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Regime de casamento</label>
                                    <input type='text' class='form-control' value="{{$socio->regime_casamento}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>E-mail</label>
                                    <input type='text' class='form-control' value="{{$socio->email}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Telefone</label>
                                    <input type='text' class='form-control' value="{{$socio->telefone}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>CPF</label>
                                    <input type='text' class='form-control' value="{{$socio->cpf}}"/>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>RG</label>
                                    <input type='text' class='form-control' value="{{$socio->rg}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Órgão Expedidor</label>
                                    <input type='text' class='form-control' value="{{$socio->orgao_expedidor}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Nacionalidade</label>
                                    <input type='text' class='form-control' value="{{$socio->nacionalidade}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>CEP</label>
                                    <input type='text' class='form-control' value="{{$socio->cep}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Estado</label>
                                    <input type='text' class='form-control' value="{{$socio->uf->nome}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Cidade</label>
                                    <input type='text' class='form-control' value="{{$socio->cidade}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Bairro</label>
                                    <input type='text' class='form-control' value="{{$socio->bairro}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Endereço</label>
                                    <input type='text' class='form-control' value="{{$socio->endereco}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Número</label>
                                    <input type='text' class='form-control' value="{{$socio->numero}}"/>
                                </div>
                                <div class='form-group'>
                                    <label>Complemento</label>
                                    <input type='text' class='form-control' value="{{$socio->complemento}}"/>
                                </div>
                            </div>
                        </div>
                        @endforeach


                        <div class="clearfix"></div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pane-cnae">
                        <br />
                        <div class='col-xs-12'>

                            <table class='table table-hover table-striped table-bordered'>
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($empresa->cnaes->count())
                                    @foreach($empresa->cnaes as $cnae)
                                    <tr>
                                        <td>{{$cnae->cnae->codigo}}</td>
                                        <td>{{$cnae->cnae->descricao}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="2">Nenhum CNAE adicionado</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class='form-group'>
                                <label>Dúvidas</label>
                                <textarea class='form-control'>{{$empresa->cnae_duvida}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar Janela</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop