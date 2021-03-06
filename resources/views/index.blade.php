@extends('layouts.master')
@section('header_title', 'Home')
@section('js')
@parent
<script type="text/javascript" language="javascript">
    var chat_id, chat_message_last_id = 0;
    var planos;
    var max_documentos;
    var max_contabeis;
    var max_pro_labores;
    var maxValor;
    var minValor;
    var max_funcionarios;
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    function updateChat() {
        $.post('{{route("atualiza-mensagens-chat")}}', {'chat_id': chat_id, 'chat_message_last_id': chat_message_last_id}, function (data) {
            console.log(data)
            if (data) {
                var html = '';
                for (i in data) {
                    chat_message_last_id = data[i].id;
                    if (data[i].atendente !== undefined) {
                        html += "<div class='mensagem atendente'>";
                        html += "<div class='nome'>" + data[i].atendente + " - " + data[i].hora + "</div>";
                        html += "<div class='texto'>" + data[i].mensagem + "</div>";
                        html += "</div>";
                    } else {
                        html += "<div class='mensagem cliente'>";
                        html += "<div class='nome'>" + data[i].nome + " - " + data[i].hora + "</div>";
                        html += "<div class='texto'>" + data[i].mensagem + "</div>";
                        html += "</div>";
                    }
                }
                $("#chat-mensagens").append(html);
                var objDiv = document.getElementById("chat-mensagens");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        });
    }
    $(function () {
        $('#contato-form').on('submit', function (e) {
            e.preventDefault();
            var nome = $('#contato-form input[name="nome"]').val();
            var assunto = $('#contato-form input[name="assunto"]').val();
            var email = $('#contato-form input[name="email"]').val();
            var mensagem = $('#contato-form textarea[name="mensagem"]').val();

            if (nome != '' && assunto != '' && email != '' && mensagem != '' && validateEmail(email)) {
                $.post("{{route('ajax-enviar-contato')}}", {nome: nome, assunto: assunto, email: email, mensagem: mensagem}, function (data) {
                    if (!data) {
                        $('#email-modal .modal-title').text('Sucesso');
                        $('#email-modal .modal-body').text('Mensagem enviada com sucesso, em breve responderemos para ' + email);
                        $('#email-modal').modal('show');
                    } else {
                        $('#email-modal .modal-title').text('Atenção');
                        $('#email-modal .modal-body').text('Ocorreu um erro ao tentar enviar a mensagem, por favor tente mais tarde.');
                        $('#email-modal').modal('show');
                    }
                });
            } else {
                $('#email-modal .modal-title').text('Atenção');
                $('#email-modal .modal-body').text('Todos os campos devem estar preenchidos corretamente.');
                $('#email-modal').modal('show');
            }

        });

        $.get("{{route('ajax-simular-plano')}}", function (data) {
            planos = data.planos;
//            max_funcionarios = parseInt(data.total_funcionarios);
            max_documentos = parseInt(data.max_documentos);
            max_contabeis = parseInt(data.max_contabeis);
            max_pro_labores = parseInt(data.max_pro_labores);
            maxValor = parseFloat(data.max_valor);
            contabilidade = parseFloat($('#contabilidade').val().replace(RegExp, "$1.$2"));

            economia = (contabilidade * 12) - (parseFloat(data.min_valor) * 12);
            $('#mensalidade').text('R$' + parseFloat(data.min_valor).toFixed(2));
            $('#economia').text('R$' + economia.toFixed(2));
        });
        $('#total_documentos, #funcionarios, #contabilidade, #total_contabeis, #pro_labores').on('keyup', function () {
            var funcionarios = $('#funcionarios').val() ? parseInt($('#funcionarios').val()) : 0;
            var acrescimo_funcionarios = 0;
            var pro_labores = $('#pro_labores').val();
            var total_documentos = $('#total_documentos').val();
            var total_contabeis = $('#total_contabeis').val();
            minValor = maxValor;
            if (pro_labores > max_pro_labores) {
                $('#pro_labores').val(max_pro_labores);
            }
            if (total_documentos > max_documentos) {
                $('#total_documentos').val(max_documentos);
            }
            if (total_contabeis > max_contabeis) {
                $('#total_contabeis').val(max_contabeis);
            }
            if (funcionarios >= 10) {
                acrescimo_funcionarios = funcionarios * 20;
            } else {
                acrescimo_funcionarios = funcionarios * 25;
            }


            for (i in planos) {

                if (total_contabeis <= parseInt(planos[i].total_documentos_contabeis) && total_documentos <= parseInt(planos[i].total_documentos) && pro_labores <= parseInt(planos[i].pro_labores) && parseFloat(planos[i].valor) < minValor) {
                    minValor = parseFloat(planos[i].valor);
                }
            }
            minValor = parseFloat(minValor + acrescimo_funcionarios).toFixed(2);
            $('#mensalidade').text('R$' + minValor);
            contabilidade = $('#contabilidade').val().replace(".", "");
            contabilidade = parseFloat(contabilidade.replace(",", "."));
            totalDesconto = (contabilidade * 12) - (minValor * 12) > 0 ? (contabilidade * 12) - (minValor * 12) : 0;

            $('#economia').html('R$' + totalDesconto.toFixed(2));

        });
        $('#chat-app form').on('submit', function (e) {
            e.preventDefault();

            $.post('{{route("envia-mensagem-chat")}}', {id_chat: chat_id, mensagem: $('#chat-app form textarea').val()}, function (data) {

            });
            $('#chat-app form textarea').empty().val(null);
            if (!$('#chat-app form textarea').val()) {

            }
        });
        $('#chat-button').on('click', function () {
            $('#chat-box').show();
        });
        $('#chat-box .btn-danger').on('click', function () {
            $('#chat-box').hide();
        });
        $('#chat-info form').on('submit', function (e) {
            e.preventDefault()
            $(this).find('input').each(function () {
                if (!$(this).val()) {
                    $('#chat-modal').modal('show');
                    return false;
                }
            });
            $.post("{{route('novo-chat')}}", {nome: $('#chat-info input[name="nome"]').val(), email: $('#chat-info input[name="email"]').val(), mensagem: $('#chat-info textarea[name="mensagem"]').val(), _token: $('#chat-info input[name="_token"]').val()}, function (data) {
                if (data.id !== undefined) {
                    var currentdate = new Date();
                    var datetime = currentdate.getHours() + ":" + (currentdate.getMinutes() < 10 ? "0" : "") + currentdate.getMinutes();
                    chat_id = data.id;
                    html = ''
                    html += "<div class='mensagem cliente'>";
                    html += "<div class='nome'>" + $('#chat-info input[name="nome"]').val() + " - " + datetime + "</div>";
                    html += "<div class='texto'>" + $('#chat-info textarea[name="mensagem"]').val() + "</div>";
                    html += "</div>";
                    $("#chat-mensagens").prepend(html);
                    $('#chat-app').show();
                    $('#chat-info').hide();
                    setInterval(updateChat, 2000);
                } else {
                    alert('nope')
                }
            })
        });
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-84798442-1', 'auto');
    ga('send', 'pageview');

</script>
@stop
@section('content')
<img id="parallax" src="{{url(public_path().'images/banner.jpg')}}"/>
<section id="inicio" style="height: 600px; overflow: hidden; position: relative; text-align: center; margin-top: 45px;">
    <h2>Sua contabilidade agora ficou digital.<br />Acesse nossos serviços onde você estiver.</h2>
    <div class="clearfix"></div>
    <a class="btn text-uppercase btn-info page-scroll" href="#planos"><span class="fa fa-calculator"></span> Simule sua mensalidade</a>
    <a class="btn btn-success text-uppercase" href='{{route('acessar')}}'><span class="fa fa-sign-in"></span> Acesse agora mesmo</a>

</section>
<section id="como-funciona" class="bg-white"> 
    <div class="container">
        <hr>
        <h1 class="title">A sua contabilidade na internet</h1>
        <hr>
        <div class="col-md-4 text-info">
            <h2 class="text-center">Público Alvo</h2>
            <div class="icon"><span class="fa fa-child"></span></div>
            <p>Para você que tem uma empresa em Santa Catarina, optante pelo Simples Nacional, fornecemos um método econômico e dinâmico para que você realize sua contabilidade.</p>
            <p>Oferecemos também serviço de <b>abertura de empresa</b> em toda Santa Catarina. Basta se <a class='{{route('acessar')}}'></a>cadastrar gratuitamente e criar uma solicitação de abertura de empresa.</p>
        </div>
        <div class="col-md-4 text-info">
            <h2 class="text-center">Como funciona</h2>
            <div class="icon"><span class="fa fa-question-circle"></span></div>
            <p>Você realiza o cadastro em nosso sistema, cadastra sua empresa e a partir disso nos envia os documentos necessários para realizarmos as apurações.</p><p>Nós lhe entregamos as guias para pagamento e lembramos a data de vencimento.<br />Isso tudo de maneira on-line.</p>

        </div>
        <div class="col-md-4 text-info">
            <h2 class="text-center">Quanto Custa?</h2>
            <div class="icon"><span class="fa fa-money"></span></div>
            <p>Nossa mensalidade custa a partir de <b>R$19,90</b> por mês e ainda o <b>primeiro mês é totalmente gratuito</b>.</p>
            <p>O <b>cadastro</b> é totalmente gratuito, as cobranças serão feitas somente quando estivermos realizando os serviços de apuração ou abertura de empresa.</p>
            <p><a class='page-scroll' href="#planos">Você pode simular sua mensalidade clicando aqui.</a></p>
        </div>
        <div class="col-xs-12 text-center">
            <br />
            <a href="{{route('acessar')}}" class="btn btn-success">Cadastre-se agora mesmo</a>
        </div>
    </div>
    <div class="clearfix"></div>
</section>
<section id="planos" class="bg-white">
    <div class="container">
        <hr>
        <h1 class="title">Simule sua mensalidade</h1>
        <hr>
        <p class="text-center">Complete os campos abaixo e confira os valores de nossas mensalidades.<br /><b>Atenção:</b> valor individual por empresa cadastrada no sistema.</p>
        <div class='col-xs-6'>
            <form>
                <div class='form-group'>
                    <label>Quantos sócios retiram pró-labore? <span data-trigger="hover" class="text-info" title="Pró-labore é o salário dos sócios que constam no contrato social da empresa, e recolhem o INSS mensalmente para a previdência social." data-toggle="tooltip" data-placement="top">(o que é isso?)</span></label>
                    <input type='text' class='form-control numero-mask2' id='pro_labores' data-mask-placeholder='0' />
                </div>
                <div class='form-group'>
                    <label>Quantos funcionários possui? <span data-trigger="hover" class="text-info" title="Quantidade de funcionários registrados na empresa. Exigido certificado digital A1." data-toggle="tooltip" data-placement="top">(o que é isso?)</span></label>
                    <input type='text' class='form-control numero-mask2' id='funcionarios' data-mask-placeholder='0' />
                </div>
                <div class='form-group'>
                    <label> Quantos documentos fiscais são emitidos e recebidos por mês? <span data-trigger="hover" class="text-info" title="Documentos fiscais, são as notas fiscais de venda ou prestação de serviço emitidas, e as notas fiscais de aquisição de mercadorias ou serviços." data-toggle="tooltip" data-placement="top" >(o que é isso?)</span></label>
                    <input type='text' class='form-control numero-mask2' id='total_documentos' data-mask-placeholder='0'/>
                </div>
                <div class='form-group'>
                    <label> Quantos documentos contábeis são emitidos por mês? <span data-trigger="hover" class="text-info" title="Neste item estão a movimentação bancária, em que cada transação corresponde a um documento contábil, assim como recibos de aluguel. Cada valor corresponderá a um documento contábil." data-toggle="tooltip" data-placement="top" >(o que é isso?)</span></label>
                    <input type='text' class='form-control numero-mask2' id='total_contabeis' data-mask-placeholder='0'/>
                </div>
                <div class='form-group'>
                    <label>Quanto você paga hoje por mês para sua contabilidade?</label>
                    <input type='text' class='form-control dinheiro-mask2' id='contabilidade' data-mask-placeholder='0' value="499,99"/>
                </div>

            </form>
        </div>
        <div class='col-xs-6'>
            <h2 class='text-center'>Sua mensalidade será:</h2>
            <div id='mensalidade' class='text-center text-info' style="font-size:45px; font-weight: bold;">R$0,00</div>
            <h2 class='text-center'>Você <b>economizará</b> por ano:</h2>
            <div id='economia' class='text-center text-success' style="font-size:45px; font-weight: bold;">R$0,00</div>
        </div>
        <div class="col-xs-12 text-center">
            <br />
            <a href="{{route('acessar')}}" class="btn btn-success">Cadastre-se agora mesmo</a>
        </div>
        <div class="clearfix"></div>
    </div>
</section>
<section id="faq" class="bg-dark">
    <div class="container">
        <hr>
        <h1 class="title">Perguntas Frequentes</h1>
        <hr>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach(\App\Faq::where('local','=','site')->get() as $k => $faq)
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading{{$faq->id}}">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$faq->id}}" aria-controls="collapse{{$faq->id}}">
                            {{$faq->pergunta}}
                        </a>
                    </h4>
                </div>
                <div id="collapse{{$faq->id}}" class="panel-collapse collapse {{$k==0 ? 'in':''}}" role="tabpanel" aria-labelledby="heading{{$faq->id}}">
                    <div class="panel-body">
                        {!!$faq->resposta!!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section id="noticias" class="bg-white">
    <div class="container">
        <hr>
        <h1 class="title">Notícias</h1>
        <hr>
        <div class='noticias col-xs-12'>
            @foreach(\App\Noticia::orderBy('created_at','desc')->limit(5)->get() as $k => $noticia)
            @if($k==0)
            <div class="noticia destaque">
                <a href="{{route('ler-noticia',[$noticia->id, str_slug($noticia->titulo)])}}">
                    <img src="{{ asset('uploads/noticias/thumb/'.$noticia->imagem) }}" />
                    <div class="titulo">{{$noticia->titulo}}</div>
                    <div class="data">{{date_format($noticia->created_at, 'd/m/Y')}}</div>
                </a>
            </div>
            @else
            <div class="noticia">
                <a href="{{route('ler-noticia',[$noticia->id, str_slug($noticia->titulo)])}}">
                    <div class="black">
                    </div>
                    <img src="{{ asset('uploads/'.$noticia->imagem) }}" />
                    <div class="titulo">{{$noticia->titulo}}</div>
                    <div class="data">{{date_format($noticia->created_at, 'd/m/Y')}}</div>
                </a>
            </div>
            @endif
            @endforeach
            <div class="clearfix"></div>
            <br />
        </div>
        <div class="text-center">
            <a href="{{route('listar-noticias-site')}}" class="btn btn-info">clique para ver mais notícias</a>
        </div>
    </div>
</section>
<section id="contato" class="bg-dark">
    <div class="container">
        <hr>
        <h1 class="title">Contato</h1>
        <hr>
        <div class="col-md-12 text-center">
            <p>Entre em contato conosco agora mesmo pelas redes sociais ou preenchendo o formulário abaixo.<br /> Assim que possível iremos responder e auxiliar com qualquer problema ou dúvida que você possa ter.</p>
        </div>
        <div class="col-md-6">
            <h2>Envie uma mensagem</h2>
            <p>Complete os campos abaixo e clique em "Enviar mensagem".</p>
            <form class="form" id="contato-form">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" value="" name="nome" placeholder="Digite seu nome"/>
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" class="form-control" value="" name="email" placeholder="Digite seu e-mail"/>
                </div>
                <div class="form-group">
                    <label>Assunto</label>
                    <input type="text" class="form-control" value="" name="assunto" placeholder="Digite o assunto"/>
                </div>
                <div class="form-group">
                    <label>Assunto</label>
                    <textarea class="form-control" placeholder="Digite a mensagem" name="mensagem"></textarea>
                </div>
                <div class="form-group ">
                    <button id="contato-enviar" type="submit" class="btn btn-success">Enviar mensagem</button>
                </div>
            </form>
        </div>
        <div class="col-md-6" id="redes-sociais">
            <h2>Redes sociais</h2>
            <p>Visite-nos também nas redes sociais, temos sempre várias novidades.</p>
            <a class="btn-link"><span class="fa fa-facebook-square"></span></a>
            <a class="btn-link"><span class="fa fa-google-plus-square"></span></a>
            <a class="btn-link"><span class="fa fa-linkedin-square"></span></a>
        </div>
    </div>
    <div class="clearfix"></div>
</section>
@if($atendimento)
<div id="chat-button">
    <button><span class="fa fa-comment"></span>Atendimento Online</button>
</div>
@endif
<div id="chat-box" style="display: none">
    <h4 class="text-uppercase text-primary">Atendimento Online</h4>
    <div id="chat-info">
        <form>
            <div class="form-group">
                <p class="text-muted">Olá, para falar com um de nossos atendentes basta completar as informações abaixo e clicar em "Iniciar Conversa".</p>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="text" name="email" placeholder="Digite seu e-mail..."  required="" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="nome" placeholder="Digite seu nome..."  required="" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Mensagem</label>
                <textarea placeholder="Digite aqui sua mensagem..." required="" name="mensagem" class="form-control"></textarea>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary">Iniciar conversa</button>
                <button class="btn btn-danger">Fechar Janela</button>
            </div>
        </form>
    </div>

    <div id="chat-app" style="display: none">
        <div id="chat-mensagens">
            <div class='mensagem atendente'>
                <div class='nome'>Sistema</div>
                <div class='texto'>Por favor aguarde, em breve você será atendido.</div>
            </div>

        </div>
        <hr>
        <form>
            <div class="form-group">
                <textarea class="form-control" placeholder="Digite uma mensagem e pressione ENTER ou clique em 'Enviar' para enviar."></textarea>
            </div>    
            <div class="form-group text-right">
                <button class="btn btn-primary">Enviar</button>
            </div>
        </form>

    </div>

</div>
<div class="modal fade" id="chat-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Atenção</h4>
            </div>
            <div class="modal-body">
                <p>É necessário completar todos os campos para iniciar um atendimento.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok, entendi</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="email-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar Janela</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
