<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Processo;
use App\ChamadoResposta;
use App\Pagamento;

class DashboardController extends Controller {

    public function index() {
        $meses = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );
        $notificacoes = \App\Notificacao::where('id_usuario', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $mensagens = ChamadoResposta::join("chamado", "chamado.id", '=', "chamado_resposta.id_chamado")->where('chamado.id_usuario', '=', Auth::user()->id)->where('chamado.status', '<>', 'Concluído')->groupBy('chamado_resposta.id_chamado')->orderBy('chamado_resposta.created_at', 'desc')->select('chamado_resposta.*')->count();
        $apuracoes = Processo::join('pessoa', 'pessoa.id', '=', 'processo.id_pessoa')->where('pessoa.id_usuario', '=', Auth::user()->id)->where('processo.status', '<>', 'concluido')->select('processo.*')->count();
        $qtde_pagamentos = Pagamento::join('mensalidade', 'mensalidade.id', '=', 'pagamento.id_mensalidade')->where('mensalidade.id_usuario', '=', Auth::user()->id)->where('pagamento.status', '!=', 'Paga')->where('pagamento.status', '!=', 'Concluída')->orderBy('pagamento.created_at', 'desc')->select('pagamento.*')->count();
        return view('dashboard.index', ['qtde_chamados' => $mensagens, 'qtde_pagamentos' => $qtde_pagamentos, 'qtde_apuracoes' => $apuracoes, 'meses' => $meses, 'notificacoes' => $notificacoes]);
    }

    public function acessar() {
        return view('acessar.index');
    }

    public function register() {
        return view('register.index');
    }

    public function checkEmail(Request $request) {
        $usuario = \App\Usuario::where('email', '=', $request->input('email'))->first();
        if ($usuario instanceof \App\Usuario) {
            return redirect(route('login'))->with('email', $request->input('email'));
        } else {
            return redirect(route('registrar'));
        }
    }

    public static function getParams() {
        $requisicao = new Client();
        $resposta = $requisicao->get('http://www8.receita.fazenda.gov.br/SimplesNacional/controleAcesso/Autentica.aspx?id=6');

        require_once 'simple_html_dom.php';

        $html = str_get_html($resposta->getBody()->getContents());
        $inputViewStateValue = $html->getElementById('__VIEWSTATE')->value;
        $inputEventValidationValue = $html->getElementById('__EVENTVALIDATION')->value;
        $urlCaptchaContainer = $html->getElementById('captcha-serpro-img-container')->{'data-url'};
        $html->clear();
        $resposta = json_decode($requisicao->get('http://www8.receita.fazenda.gov.br/' . $urlCaptchaContainer . 'Inicializa.ashx?clientId=00000000000000000000000000000000')->getBody()->getContents());
        $imgReturn = 'data:image/png;base64,' . $resposta->Dados;
//        return $imgReturn;
        return [
            'cookie' => 'captcha_token=' . $resposta->Token,
            'viewState' => $inputViewStateValue,
            'eventValidation' => $inputEventValidationValue,
            'captchaBase64' => $imgReturn
        ];
    }

    public function consultaAjax(Request $request) {
        return $this->consulta($request->get('cnpj'), $request->get('cpf'), $request->get('codigoAcesso'), $request->get('input_captcha'), $request->get('cookie'), $request->get('viewState'), $request->get('eventValidation'));
    }

    public function ajaxNotificacao(Request $request) {
        if ($request->get('id')) {
            \App\Notificacao::where('id', '=', $request->get('id'))->where('id_usuario', '=', Auth::user()->id)->first()->delete();
        }
        $notificacoes = \App\Notificacao::where('id_usuario', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json($notificacoes);
    }

    public function consulta($cnpj, $cpf, $codigo, $captcha, $stringCookie, $viewState, $eventValidation) {
        $jar = new \GuzzleHttp\Cookie\CookieJar;
        $requisicao = new Client(['cookies' => true]);
        $param = [
            'form_params' => [
                '__VIEWSTATE' => $viewState,
                '__EVENTVALIDATION' => $eventValidation,
                'ctl00$txtBusca' => '',
                'ctl00$ContentPlaceHolder$txtCNPJ' => $cnpj,
                'ctl00$ContentPlaceHolder$txtCPFResponsavel' => $cpf,
                'ctl00$ContentPlaceHolder$txtCodigoAcesso' => $codigo,
                'txtTexto_captcha' => $captcha,
                'hdn_client_id' => '00000000000000000000000000000000',
                'ctl00$ContentPlaceHolder$btContinuar' => 'Continuar'
            ],
            'headers' => [
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate',
                'Accept-Language' => 'pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4',
                'Cache-Control' => 'max-age=0',
                'Connection' => 'keep-alive',
                'Content-type' => 'application/x-www-form-urlencoded',
                'Cookie' => $stringCookie,
                'Host' => 'www8.receita.fazenda.gov.br',
                'Origin' => 'http://www8.receita.fazenda.gov.br',
                'Referer' => 'http://www8.receita.fazenda.gov.br/SimplesNacional/controleAcesso/Autentica.aspx?id=6',
                'Upgrade-Insecure-Requests' => '1',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
            ],
            'timeout' => 20, // Response timeout
            'connect_timeout' => 20, // Connection timeout
        ];
        $resposta = $requisicao->post('http://www8.receita.fazenda.gov.br/SimplesNacional/controleAcesso/Autentica.aspx?id=6', $param);
        require_once 'simple_html_dom.php';
        $html = str_get_html($resposta->getBody()->getContents());
//        echo $resposta->getBody()->getContents();

        $erros = $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblErroCaptcha');
        if (is_object($erros)) {
            $mensagemErro = 'Ocorreu algum erro, tente novamente mais tarde';
            switch (trim($erros->plaintext)) {
                case 'Caracteres anti-robô inválidos. Tente novamente.':
                    $mensagemErro = 'Erro ao consultar. Verifique se digitou corretamente o captcha.';
                    break;
                case 'O CNPJ informado deve conter 14 dígitos.':
                    $mensagemErro = 'Erro ao consultar. CNPJ deve conter 14 dígitos.';
                    break;
                case 'O CNPJ digitado é inválido.':
                    $mensagemErro = 'Erro ao consultar. CNPJ inválido.';
                    break;
            }
            throw new \Exception($mensagemErro, 99);
        }
        return str_replace('./', 'http://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgdasd.app/', $resposta->getBody());
        return [
            'cnpj' => $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblCNPJ')->plaintext,
            'nome_empresarial' => $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblNomeEmpresa')->plaintext,
            'situacao_simples_nacional' => $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblSituacaoSimples')->plaintext,
            'situacao_simei' => $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblSituacaoMei')->plaintext,
            'opcoes_pelo_simples_nacional_periodos_anteriores' => $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblPeriodoAnterior > b > font')->plaintext,
            'opcoes_pelo_simei_periodos_anteriores' => $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblSIMEIPeriodosAnteriores > b > font')->plaintext,
            'agendamentos_simples_nacional' => $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblAgendamentosOpcaoSinac > b > font')->plaintext,
            'eventos_futuros_simples_nacional' => $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblEventosFuturos > b > font')->plaintext,
            'eventos_futuros_simei' => $html->getElementById('ctl00_ContentPlaceHolderConteudo_lblEventosFuturosSimei > b > font')->plaintext
        ];
    }

}
