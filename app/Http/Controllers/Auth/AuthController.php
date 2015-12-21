<?php

namespace App\Http\Controllers\Auth;

use App\Usuario;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */
use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    private $redirectTo = '/dashboard';
    private $maxLoginAttempts = 10;
    protected $loginPath = '/login';
    protected $registerPath = '/register';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'getLogout']);
        
    }

    public function getRegister() {
        return view('register.index');
    }

    public function getLogin() {
        return view('login.index');
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'nome' => 'required|max:255',
                    'telefone' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:usuario',
                    'senha' => 'required|confirmed|min:6',
                    'senha_confirmation' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Usuario
     */
    protected function create(array $data) {
        return Usuario::create([
                    'nome' => $data['nome'],
                    'email' => $data['email'],
                    'telefone' => $data['telefone'],
                    'senha' => bcrypt($data['senha']),
        ]);
    }

}
