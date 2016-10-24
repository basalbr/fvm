@extends('layouts.dashboard')
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
<h1>Processo de abertura de empresa</h1>
<hr class="dash-title">
<div class="col-xs-12">
    <div class="card">
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
        @if($empresa->status != 'Cancelado' && $empresa->status != 'Concluído')
        <form method="POST" action="" enctype="multipart/form-data">
            <h3>Nova Mensagem</h3>
            <div class='col-xs-12'>
            {{ csrf_field() }}
            
            <div class='form-group'>
                <label>Anexar arquivo</label>
                <input type='file' class='form-control' value="" name='anexo'/>
            </div>
            <div class='form-group'>
                <textarea class="form-control" name='mensagem'></textarea>
            </div>
            <div class='form-group'>
                <input type='submit' value="Enviar mensagem" class='btn btn-primary' />
            </div>
            </div>
        </form>
        @endif
        <h3>Últimas mensagens:</h3>
        <div class='col-xs-12'>
        @if($empresa->mensagens->count())
        @foreach($empresa->mensagens()->orderBy('updated_at', 'desc')->get() as $resposta)
        <div class='form-group'>
            <div class="mensagem {{$resposta->usuario->id == Auth::user()->id ? 'mensagem-usuario':'mensagem-admin'}}">
                <p class='title'>{{$resposta->usuario->nome}} em {{date_format($resposta->updated_at, 'd/m/Y')}} às {{date_format($resposta->updated_at, 'H:i')}}</p>
                {{$resposta->mensagem}}
            </div>
        </div>
        @endforeach
        @else
        <p>Nenhuma mensagem encontrada</p>
        @endif
        </div>
        <div class="clearfix"></div>
    </div>
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
                        <div class='col-xs-12'>
                            <br />
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
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pane-endereco">
                        <div class='col-xs-12'>
                            <br />
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
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pane-socios">
                        <div class='col-xs-12'>
                            <br />
                            <div class='table-responsive'>
                                <table class='table table-bordered table-hover table-striped'>
                                    <thead>
                                        <tr>
                                            <th>Principal?</th>
                                            <th>Nome</th>
                                            <th>Nome da mãe</th>
                                            <th>Nome da pai</th>
                                            <th>Data de nascimento</th>
                                            <th>Estado civil</th>
                                            <th>Regime de casamento</th>
                                            <th>E-mail</th>
                                            <th>Telefone</th>
                                            <th>CPF</th>
                                            <th>RG</th>
                                            <th>Órgão Expedidor</th>
                                            <th>Nacionalidade</th>
                                            <th>CEP</th>
                                            <th>Estado</th>
                                            <th>Cidade</th>
                                            <th>Bairro</th>
                                            <th>Endereço</th>
                                            <th>Número</th>
                                            <th>Complemento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($empresa->socios as $socio)
                                        <tr>
                                            <td>{{$socio->principal ? 'Sim' : 'Não' }}</td>
                                            <td>{{$socio->nome}}</td>
                                            <td>{{$socio->nome_mae}}</td>
                                            <td>{{$socio->nome_pai}}</td>
                                            <td>{{$socio->data_nascimento->format('d/m/Y')}}</td>
                                            <td>{{$socio->estado_civil}}</td>
                                            <td>{{$socio->regime_casamento}}</td>
                                            <td>{{$socio->email}}</td>
                                            <td>{{$socio->telefone}}</td>
                                            <td>{{$socio->cpf}}</td>
                                            <td>{{$socio->rg}}</td>
                                            <td>{{$socio->orgao_expedidor}}</td>
                                            <td>{{$socio->nacionalidade}}</td>
                                            <td>{{$socio->cep}}</td>
                                            <td>{{$socio->uf->nome}}</td>
                                            <td>{{$socio->cidade}}</td>
                                            <td>{{$socio->bairro}}</td>
                                            <td>{{$socio->endereco}}</td>
                                            <td>{{$socio->numero}}</td>
                                            <td>{{$socio->complemento}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pane-cnae">
                        <div class='col-xs-12'>
                            <br />
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
                                        <td>{{$cnaes->cnae->codigo}}</td>
                                        <td>{{$cnaes->cnae->descricao}}</td>
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