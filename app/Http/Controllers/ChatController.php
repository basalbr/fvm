<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Chat;
use App\ChatMensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller {

    public function index() {
        $chat = Chat::orderBy('updated_at', 'desc')->get();
        return view('admin.chat.index', ['chat' => $chat]);
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
            $request->merge(['id_usuario' => Auth::user()->id, 'nome'=>Auth::user()->nome,'email'=>Auth::user()->nome]);
        }
        if ($chat->validate($request->all())) {
            $chat = $chat->create($request->all());
            return response()->json(['id'=>$chat->id]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function edit($id) {
        $chat = Chat::where('id', '=', $id)->first();
        return view('chat.visualizar', ['chat' => $chat]);
    }

    public function update($id, Request $request) {
        $resposta = new ChatResposta;
        $request->merge(['id_usuario' => Auth::user()->id]);
        $request->merge(['id_chat' => $id]);
        if ($resposta->validate($request->only('mensagem'))) {
            $resposta->create($request->only('mensagem', 'id_usuario', 'id_chat'));
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
            $nova_mensagem->create($request->all());
        }
    }
    
        public function getMensagensAjax(Request $request){
            
            $mensagens = ChatMensagem::where('id_chat','=',$request->get('chat_id'))->where('id','>',$request->get('chat_message_last_id'))->orderBy('id','asc')->get();
            $json = [];
            foreach($mensagens as $k => $mensagem){
                if($mensagem->id_atendente){
                    $json[] = ['id'=>$mensagem->id, 'mensagem'=>$mensagem->mensagem, 'atendente'=>$mensagem->atendente->nome, 'hora'=>  date_format($mensagem->created_at, 'H:i:s')];
                }else{
                    $json[] = ['id'=>$mensagem->id,'mensagem'=>$mensagem->mensagem,'nome'=>$mensagem->chat->nome, 'hora'=>  date_format($mensagem->created_at, 'H:i:s')];
                }
            }
            return response()->json($json);
            
        }
        

}
