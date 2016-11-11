<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller {

    public function index() {
        $faqs = Faq::orderBy('local', 'asc')->orderBy('pergunta', 'asc')->paginate(10);
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
