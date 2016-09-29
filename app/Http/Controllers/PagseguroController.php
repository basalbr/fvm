<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use laravel\pagseguro\Platform\Laravel5\PagSeguro;


class PagseguroController extends Controller {

    public function redirect(Request $r) {
        $credentials = PagSeguro::credentials()->get();
        $transaction = PagSeguro::transaction()->get('123', $credentials);

        $information = $transaction->getInformation();
        dd($information);
    }


    public function teste() {
        $data = [
            'items' => [
                [
                    'id' => '18',
                    'description' => 'Item Um',
                    'quantity' => '1',
                    'amount' => '1.15',
                ],
            ],
            'notificationURL'=>'http://www.webcontabilidade.com/pagseguro',
            'reference'=>'123',
            'sender' => [
                'email' => 'c88672221307210906171@sandbox.pagseguro.com.br',
                'name' => 'Aldir Junior',
                'documents' => [
                    [
                        'number' => '06873589900',
                        'type' => 'CPF'
                    ]
                ],
                'phone' => '(47)9617-2512',
                'bornDate' => '1989-03-10',
            ]
        ];
        $checkout = Pagseguro::checkout()->createFromArray($data);
        $credentials = PagSeguro::credentials()->get();
        $information = $checkout->send($credentials); // Retorna um objeto de laravel\pagseguro\Checkout\Information\Information
        if ($information) {
            print_r($information->getCode());
            print_r($information->getDate());
            print_r($information->getLink());
        }
    }

}
