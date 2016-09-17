@extends('layouts.master')
@section('header_title', 'Home')
@section('js')
@parent
<script type="text/javascript">
    var chat_id, chat_message_last_id = 0;
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

        $('#chat-app form').on('submit', function (e) {
            e.preventDefault();
            $('#chat-app form textarea').empty().val(null);
            if (!$('#chat-app form textarea').val()) {

            }
            $.post('{{route("envia-mensagem-chat")}}', {id_chat: chat_id, mensagem: $('#chat-app form textarea').val()}, function (data) {

            });
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
    });
</script>
@stop
@section('content')
<img id="parallax" src="{{url('public/images/banner.jpg')}}"/>
<section id="inicio" style="height: 600px; overflow: hidden; position: relative; text-align: center">
    <h1 class="text-uppercase">F.V.M</h1>
    <h2 class="text-uppercase">faça você mesmo</h2>
    <a class="btn btn-default text-uppercase">Clique para conhecer</a>
    <a class="btn btn-default text-uppercase" href='{{route('acessar')}}'>clique para acessar</a>

</section>
<section id="como-funciona" class="bg-white bg-shadow">
    <div class="container">
        <hr>
        <h1 class="title">Como Funciona</h1>
        <hr>
        <div class="col-md-4">
            <h2>Simples</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non velit vel mi pretium laoreet. Cras id tellus at diam dictum iaculis non sollicitudin diam. Praesent facilisis vehicula gravida. Proin fermentum, eros nec porta gravida, elit orci semper turpis, eu aliquam lorem odio a nunc. Suspendisse interdum eleifend consequat. Maecenas non condimentum tellus, sed volutpat turpis. Aenean quam turpis, fermentum vel tortor sed, mattis venenatis dolor. Vivamus condimentum sagittis libero id hendrerit. Nullam molestie enim a urna molestie, nec volutpat urna feugiat.

                In finibus sagittis ex, a varius est elementum rutrum. Fusce in facilisis turpis, a tincidunt erat. Phasellus a ex quis leo malesuada ullamcorper. Donec porta eu mauris quis condimentum. Integer imperdiet libero mauris, in mattis ligula feugiat non. Vestibulum vel imperdiet erat, quis aliquet erat. Nulla non ligula convallis, eleifend augue facilisis, auctor quam. Maecenas ac facilisis diam. Fusce rutrum eros neque, tincidunt viverra ligula vestibulum non. Etiam posuere venenatis nisl nec molestie. Sed in nulla vel diam consequat semper. Aliquam nec lectus nunc. Vestibulum odio lorem, tempor nec luctus quis, eleifend eget nulla.</p>
        </div>
        <div class="col-md-4">
            <h2>Fácil</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non velit vel mi pretium laoreet. Cras id tellus at diam dictum iaculis non sollicitudin diam. Praesent facilisis vehicula gravida. Proin fermentum, eros nec porta gravida, elit orci semper turpis, eu aliquam lorem odio a nunc. Suspendisse interdum eleifend consequat. Maecenas non condimentum tellus, sed volutpat turpis. Aenean quam turpis, fermentum vel tortor sed, mattis venenatis dolor. Vivamus condimentum sagittis libero id hendrerit. Nullam molestie enim a urna molestie, nec volutpat urna feugiat.

                In finibus sagittis ex, a varius est elementum rutrum. Fusce in facilisis turpis, a tincidunt erat. Phasellus a ex quis leo malesuada ullamcorper. Donec porta eu mauris quis condimentum. Integer imperdiet libero mauris, in mattis ligula feugiat non. Vestibulum vel imperdiet erat, quis aliquet erat. Nulla non ligula convallis, eleifend augue facilisis, auctor quam. Maecenas ac facilisis diam. Fusce rutrum eros neque, tincidunt viverra ligula vestibulum non. Etiam posuere venenatis nisl nec molestie. Sed in nulla vel diam consequat semper. Aliquam nec lectus nunc. Vestibulum odio lorem, tempor nec luctus quis, eleifend eget nulla.</p>
        </div>
        <div class="col-md-4">
            <h2>Dinâmico</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non velit vel mi pretium laoreet. Cras id tellus at diam dictum iaculis non sollicitudin diam. Praesent facilisis vehicula gravida. Proin fermentum, eros nec porta gravida, elit orci semper turpis, eu aliquam lorem odio a nunc. Suspendisse interdum eleifend consequat. Maecenas non condimentum tellus, sed volutpat turpis. Aenean quam turpis, fermentum vel tortor sed, mattis venenatis dolor. Vivamus condimentum sagittis libero id hendrerit. Nullam molestie enim a urna molestie, nec volutpat urna feugiat.

                In finibus sagittis ex, a varius est elementum rutrum. Fusce in facilisis turpis, a tincidunt erat. Phasellus a ex quis leo malesuada ullamcorper. Donec porta eu mauris quis condimentum. Integer imperdiet libero mauris, in mattis ligula feugiat non. Vestibulum vel imperdiet erat, quis aliquet erat. Nulla non ligula convallis, eleifend augue facilisis, auctor quam. Maecenas ac facilisis diam. Fusce rutrum eros neque, tincidunt viverra ligula vestibulum non. Etiam posuere venenatis nisl nec molestie. Sed in nulla vel diam consequat semper. Aliquam nec lectus nunc. Vestibulum odio lorem, tempor nec luctus quis, eleifend eget nulla.</p>
        </div>
    </div>
    <div class="clearfix"></div>
</section>
<section id="planos" class="bg-dark">
    <div class="container">
        <hr>
        <h1 class="title">Planos</h1>
        <hr>
        <div class="pricing-table">
            <div class="col-lg-4 col-md-4 col-sm-4 ">
                <ul class="plan plan1">
                    <li class="plan-name">
                        Basic
                    </li>
                    <li class="plan-price">
                        <h3> $19 <span class="price-cents">99</span><span class="price-month">/month</span></h3>
                    </li>
                    <li>
                        <strong>5GB</strong> Storage
                    </li>
                    <li>
                        <strong>1GB</strong> RAM
                    </li>
                    <li>
                        <strong>400GB</strong> Bandwidth
                    </li>
                    <li>
                        <strong>10</strong> Email Address
                    </li>
                    <li>
                        <strong>Forum</strong> Support
                    </li>
                    <li class="plan-action">
                        <a href="#" class="btn btn-blue btn-lg"> Signup </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 ">
                <ul class="plan plan2 featured">
                    <li class="plan-name">
                        Standard
                    </li>
                    <li class="plan-price">
                        <h3> $29 <span class="price-cents">99</span><span class="price-month">/month</span></h3>
                    </li>
                    <li>
                        <strong>5GB</strong> Storage
                    </li>
                    <li>
                        <strong>1GB</strong> RAM
                    </li>
                    <li>
                        <strong>400GB</strong> Bandwidth
                    </li>
                    <li>
                        <strong>10</strong> Email Address
                    </li>
                    <li>
                        <strong>Forum</strong> Support
                    </li>
                    <li class="plan-action">
                        <a href="#" class="btn btn-blue btn-lg"> Signup </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 ">
                <ul class="plan plan3">
                    <li class="plan-name">
                        Advanced
                    </li>
                    <li class="plan-price">
                        <h3> $49 <span class="price-cents">99</span><span class="price-month">/month</span></h3>
                    </li>
                    <li>
                        <strong>50GB</strong> Storage
                    </li>
                    <li>
                        <strong>8GB</strong> RAM
                    </li>
                    <li>
                        <strong>1024GB</strong> Bandwidth
                    </li>
                    <li>
                        <strong>Unlimited</strong> Email Address
                    </li>
                    <li>
                        <strong>Forum</strong> Support
                    </li>
                    <li class="plan-action">
                        <a href="#" class="btn btn-blue btn-lg"> Signup </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</section>
<section id="contato" class="bg-white bg-shadow">
    <div class="container">
        <hr>
        <h1 class="title">Contato</h1>
        <hr>
        <div class="col-md-12 text-center">
            <p>Entre em contato conosco agora mesmo pelas redes sociais ou preenchendo o formulário abaixo.<br /> Assim que possível iremos responder e auxiliar com qualquer problema ou dúvida que você possa ter.</p>
        </div>
        <div class="col-md-6">
            <h3>Envie uma mensagem</h3>
            <p>Complete os campos abaixo e clique em "Enviar mensagem".</p>
            <form class="form" id="contato-form">
                <div class="form-group col-xs-12">
                    <label>Nome</label>
                    <input type="text" class="form-control" value="" name="nome" placeholder="Digite seu nome"/>
                </div>

                <div class="form-group col-xs-12">
                    <label>E-mail</label>
                    <input type="text" class="form-control" value="" name="email" placeholder="Digite seu e-mail"/>
                </div>
                <div class="form-group col-xs-12">
                    <label>Assunto</label>
                    <textarea class="form-control" placeholder="Digite o assunto" name="assunto"></textarea>
                </div>
                <div class="form-group col-xs-12">
                    <button id="contato-enviar" type="submit" class="btn btn-success">Enviar mensagem</button>
                </div>
            </form>
        </div>
        <div class="col-md-6" id="redes-sociais">
            <h3>Redes sociais</h3>
            <p>Visite-nos também nas redes sociais, temos sempre várias novidades.</p>
            <a class="btn-link"><span class="fa fa-facebook-square"></span></a>
            <a class="btn-link"><span class="fa fa-google-plus-square"></span></a>
            <a class="btn-link"><span class="fa fa-linkedin-square"></span></a>
        </div>
    </div>
    <div class="clearfix"></div>
</section>
<div id="chat-button">
    <button><span class="fa fa-comment"></span>Atendimento Online</button>
</div>
<div id="chat-box">
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
@stop