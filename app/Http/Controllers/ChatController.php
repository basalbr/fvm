<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Chat;
use App\ChatMensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ChatController extends Controller {
  public function delete($id) {
        $chat = Chat::where('id', '=', $id)->first();
        $chat->delete();
        return redirect()->route('listar-chat');
    }
    public function index() {
        $chats = Chat::query();
        if (Input::get('de')) {
            $data = explode('/', Input::get('de'));
            $data = $data[2] . '-' . $data[1] . '-' . $data[0];
            $chats->where('created_at', '>=', $data);
        }
        if (Input::get('ate')) {
            $data = explode('/', Input::get('ate'));
            $data = $data[2] . '-' . $data[1] . '-' . $data[0];
            $chats->where('created_at', '<=', $data);
        }
        if (Input::get('nome')) {
            $chats->where('nome', 'like', '%' . Input::get('nome') . '%');
        }
        if (Input::get('email')) {
            $chats->where('email', 'like', '%' . Input::get('email') . '%');
        }

        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'atualizado_desc') {
                $chats->orderBy('updated_at', 'desc');
            }
            if (Input::get('ordenar') == 'atualizado_asc') {
                $chats->orderBy('updated_at', 'asc');
            }
            if (Input::get('ordenar') == 'nome_desc') {
                $chats->orderBy('nome', 'desc');
            }
            if (Input::get('ordenar') == 'nome_asc') {
                $chats->orderBy('nome', 'asc');
            }
            if (Input::get('ordenar') == 'email_desc') {
                $chats->orderBy('email', 'desc');
            }
            if (Input::get('ordenar') == 'email_asc') {
                $chats->orderBy('email', 'asc');
            }
        } else {
            $chats->orderBy('updated_at', 'desc');
        }
        $chats = $chats->paginate(10);
        return view('admin.chat.index', ['chats' => $chats]);
    }

    public function indexUsuario() {
        $chat = Chat::where('id_usuario', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        return view('chat.index', ['chat' => $chat]);
    }

    public function create() {
        return view('chat.cadastrar');
    }

    public function storeAjax(Request $request) {
        $chat = new Chat;
        if (Auth::user()) {
            $request->merge(['id_usuario' => Auth::user()->id, 'nome' => Auth::user()->nome, 'email' => Auth::user()->email]);
        }
        if ($chat->validate($request->all())) {
            $chat = $chat->create($request->all());
            return response()->json(['id' => $chat->id]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function edit($id) {
        $chat = Chat::where('id', '=', $id)->first();
        return view('admin.chat.visualizar', ['chat' => $chat]);
    }

    public function update($id, Request $request) {
        $resposta = new ChatResposta;
        $request->merge(['id_usuario' => Auth::user()->id]);
        $request->merge(['id_chat' => $id]);
        if ($resposta->validate($request->only('mensagem'))) {
            $mensagem = $resposta->create($request->only('mensagem', 'id_usuario', 'id_chat'));
            $mensagem->chat()->touch();
            if ($request->is('admin/*')) {
                return redirect(route('listar-chat'));
            }
            return redirect(route('listar-chat-usuario'));
        } else {
            if ($request->is('admin/*')) {
                return redirect(route('visualizar-chat', $id))->withInput()->withErrors($resposta->errors());
            }
            return redirect(route('responder-chat-usuario', $id))->withInput()->withErrors($resposta->errors());
        }
    }

    public function updateAjax(Request $request) {
        $nova_mensagem = new ChatMensagem;
        if ($nova_mensagem->validate($request->all())) {
            $mensagem = $nova_mensagem->create($request->all());
        }
        $mensagem->chat()->touch();
    }

    public function getMensagensAjax(Request $request) {

        $mensagens = ChatMensagem::where('id_chat', '=', $request->get('chat_id'))->where('id', '>', $request->get('chat_message_last_id'))->orderBy('id', 'asc')->get();
        $json = [];
        foreach ($mensagens as $k => $mensagem) {
            if ($mensagem->id_atendente) {
                $json[] = ['id' => $mensagem->id, 'mensagem' => $mensagem->mensagem, 'atendente' => $mensagem->atendente->nome, 'hora' => date_format($mensagem->created_at, 'H:i')];
            } else {
                $json[] = ['id' => $mensagem->id, 'mensagem' => $mensagem->mensagem, 'nome' => $mensagem->chat->nome, 'hora' => date_format($mensagem->created_at, 'H:i')];
            }
        }
        return response()->json($json);
    }

    public function ajaxCount() {
        return (int) Chat::count();
    }

    public function ajaxNotification() {
        $total = Chat::count();
        $ultimo_chat = Chat::orderBy('created_at', 'desc')->first();
        if ($total > 0) {
            $url = route('visualizar-chat', [$ultimo_chat->id]);
            return response()->json(['total' => $total, 'title' => $ultimo_chat->nome, 'message' => $ultimo_chat->mensagem, 'url' => $url]);
        }
        return response()->json(['total' => $total, 'title' => '', 'message' => '', 'url' => '']);
    }

}
