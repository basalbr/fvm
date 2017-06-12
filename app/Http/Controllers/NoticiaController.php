<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Noticia;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class NoticiaController extends Controller {

    public function index() {
        $noticias = Noticia::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.noticias.index', ['noticias' => $noticias]);
    }

    public function indexSite() {
        $noticias = Noticia::orderBy('created_at', 'desc')->where('created_at', '<', 'NOW()')->get();
        return view('noticias.index', ['noticias' => $noticias]);
    }

    public function ler($id) {
        $noticia = Noticia::find($id);
        return view('noticias.ler', ['noticia' => $noticia]);
    }

    public function create() {
        return view('admin.noticias.cadastrar');
    }

    public function store(Request $request) {
        $noticia = new Noticia;
        if ($noticia->validate($request->all())) {

            list($day, $month, $year) = explode("/", $request->created_at);
            $request->merge(['created_at' => $year . '-' . $month . '-' . $day]);
            $imagem = date('dmyhis') . '.' . $request->file('imagem')->getClientOriginalExtension();
            $request->file('imagem')->move(getcwd() . '/uploads/noticias/', $imagem);
            $request->merge(['imagem' => $imagem]);
            $img = Image::make(getcwd() . '/uploads/noticias/' . $imagem);
            $img->fit(600, 400);
            $img->save(getcwd() . '/uploads/noticias/thumb/' . $imagem);

            $noticia = $noticia->create($request->all());
            $noticia->imagem = $imagem;
            $noticia->save();
            return redirect(route('listar-noticias'));
        } else {
            return redirect(route('cadastrar-noticia'))->withInput()->withErrors($noticia->errors());
        }
    }

    public function edit($id_noticia) {
        $noticia = Noticia::where('id', '=', $id_noticia)->first();
        return view('admin.noticias.editar', ['noticia' => $noticia]);
    }

    public function update($id_noticia, Request $request) {
        $noticia = Noticia::where('id', '=', $id_noticia)->first();
        if(!$request->file('imagem')){
            $request->merge(['imagem'=>$noticia->imagem]);
        }
        if ($noticia->validate($request->all())) {
            list($day, $month, $year) = explode("/", $request->created_at);
            $request->merge(['created_at' => $year . '-' . $month . '-' . $day]);
            if ($request->file('imagem')) {
                $imagem = date('dmyhis') . '.' . $request->file('imagem')->getClientOriginalExtension();
                $request->file('imagem')->move(getcwd() . '/uploads/noticias/', $imagem);
                $request->merge(['imagem' => $imagem]);
                $img = Image::make(getcwd() . '/uploads/noticias/' . $imagem);
                $img->fit(600, 400);
                $img->save(getcwd() . '/uploads/noticias/thumb/' . $imagem);
                $noticia->imagem = $imagem;
            }
            $noticia = $noticia->update($request->except('imagem'));
            return redirect(route('listar-noticias'));
        } else {
            return redirect(route('editar-noticia', ['id_noticia' => $id_noticia]))->withInput()->withErrors($noticia->errors());
        }
    }

}
