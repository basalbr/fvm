<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Processo;
use App\ProcessoResposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\DocumentoContabil;
use App\ProcessoDocumentoContabil;
use App\TipoDocumentoContabil;
use App\Arquivos\DocumentoContabil as Arquivo;

class DocumentoContabilController extends Controller {

    public function index($id) {
        $processo = ProcessoDocumentoContabil::find($id);
        $documentos = DocumentoContabil::query();
        $documentos->join('processo_documento_contabil as pdc', 'pdc.id', '=', 'documento_contabil.id_processo_documento_contabil');
        $documentos->join('pessoa as p', 'p.id', '=', 'pdc.id_pessoa');
        $documentos->where('p.id_usuario', '=', Auth::user()->id);
        $documentos->where('pdc.id', '=', $id);
        $documentos = $documentos->paginate(10);

        return view('documentos_contabeis.documentos', ['documentos' => $documentos, 'processo' => $processo]);
    }
    public function indexAdmin($id) {
        $processo = ProcessoDocumentoContabil::find($id);
        $documentos = DocumentoContabil::query();
        $documentos = $documentos->paginate(10);

        return view('admin.documentos_contabeis.documentos', ['documentos' => $documentos, 'processo' => $processo]);
    }

    public function create($id) {
        $tipos = TipoDocumentoContabil::orderBy('descricao')->get();
        return view('documentos_contabeis.cadastrar', ['tipos' => $tipos, 'processo_id' => $id]);
    }

    public function store($id, Request $request) {
        $processo = ProcessoDocumentoContabil::join('pessoa', 'pessoa.id', '=', 'processo_documento_contabil.id_pessoa')
                ->where('pessoa.id_usuario', '=', Auth::user()->id)
                ->where('processo_documento_contabil.id', '=', $id)
                ->select('processo_documento_contabil.*')
                ->first();
        if ($processo instanceof ProcessoDocumentoContabil) {
            $docs = $request->get('documentos');
            if (count($docs)) {
                foreach ($docs as $doc) {
                    $doc['id_processo_documento_contabil'] = $id;
                    $documento_contabil = new DocumentoContabil;
                    if ($documento_contabil->validate($doc)) {
                        $documento_contabil->create($doc);
                    } else {
                        return redirect(route('enviar-documento-contabil', [$id]))->withErrors($documento_contabil->errors());
                    }
                }
                $processo->status = 'documentos_enviados';
                $processo->save();
                $processo->enviar_novo_status();
                return redirect(route('listar-documento-contabil', [$id]));
            } else {
                return redirect(route('enviar-documento-contabil', [$id]))->withErrors(['É necessário anexar pelo menos um documento.']);
            }
        } else {
            return redirect(route('enviar-documento-contabil', [$id]))->withErrors(['Ocorreu um erro ao tentar cadastrar, tente atualizar a página.']);
        }
    }

    public function upload($id, Request $request) {
        $arquivo = new Arquivo($request->file('anexo'));
        if (count($arquivo->getErros())) {
            return response()->json(['status' => 'erro', 'erros' => $arquivo->getErros()], 400);
        }
        return response()->json(['status' => 'ok', 'documento' => $arquivo->getNomeArquivo()], 200);
    }

}
