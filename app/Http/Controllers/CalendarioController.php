<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CalendarioController extends Controller {

    public function index() {
        return view('calendario.index');
    }


}
