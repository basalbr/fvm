<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mensalidade;
use Illuminate\Support\Facades\Auth;

class MensalidadeController extends Controller {

    public function index() {
        $mensalidades = Mensalidade::where('id_usuario','=',Auth::user()->id)->get();
        return view('mensalidades.index', ['mensalidades' => $mensalidades]);
    }
 public function indexAdmin() {
        $mensalidades = Mensalidade::get();
        return view('admin.mensalidades.index', ['mensalidades' => $mensalidades]);
    }

}
