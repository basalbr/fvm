<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class RegistroController extends Controller {

    public function index() {
       return view('register.index');
    }

    public function store() {
        return view('acessar.index');
    }

}
