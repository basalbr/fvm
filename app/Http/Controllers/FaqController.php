<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class FaqController extends Controller {

    public function index() {
        $faqs = Faq::query();
        if (Input::get('pergunta')) {
            $faqs->where('pergunta', 'like', '%' . Input::get('pergunta') . '%');
        }
        if (Input::get('resposta')) {
            $faqs->where('resposta', 'like', '%' . Input::get('resposta') . '%');
        }
        if (Input::get('local')) {
            $faqs->where('local', '=', Input::get('local'));
        }
      
        if (Input::get('ordenar')) {
            if (Input::get('ordenar') == 'pergunta_asc') {
                $faqs->orderBy('pergunta', 'asc');
            }
            if (Input::get('ordenar') == 'pergunta_desc') {
                $faqs->orderBy('pergunta', 'desc');
            }
            if (Input::get('ordenar') == 'resposta_asc') {
                $faqs->orderBy('resposta', 'asc');
            }
            if (Input::get('ordenar') == 'resposta_desc') {
                $faqs->orderBy('resposta', 'desc');
            }
            if (Input::get('ordenar') == 'area_asc') {
                $faqs->orderBy('local', 'asc');
            }
            if (Input::get('ordenar') == 'area_desc') {
                $faqs->orderBy('local', 'desc');
            }
        } else {
            $faqs->orderBy('pergunta', 'asc');
        }
        $faqs = $faqs->paginate(10);
        return view('admin.faq.index', ['faqs' => $faqs]);
    }

    public function create() {
        return view('admin.faq.cadastrar');
    }

    public function store(Request $request) {
        $faq = new Faq;
        if ($faq->validate($request->all())) {
            $faq->create($request->all());
            return redirect(route('listar-faq'));
        } else {
            return redirect(route('cadastrar-faq'))->withInput()->withErrors($faq->errors());
        }
    }

    public function edit($id) {
        $faq = Faq::where('id', '=', $id)->first();
        return view('admin.faq.editar', ['faq' => $faq]);
    }

    public function update($id, Request $request) {
        $faq = Faq::where('id', '=', $id)->first();
        if ($faq->validate($request->all())) {
            $faq->update($request->all());
            return redirect(route('listar-faq'));
        } else {
            return redirect(route('editar-faq'))->withInput()->withErrors($faq->errors());
        }
    }

}
