<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Stripe;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function stripePay(Request $request)
    {
         \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $res =  \Stripe\Customer::create([
            'email' => 'dev.mohamed111@gmail.com',
            'name' => 'Mostafa Ahmed',
            'currency' => 'usd',
            'phone' => '+201016806280',
          ]);
          return $res;

        Stripe\Charge::create ([
            "amount" => 100*1000,
            "currency" => "usd",
            "customer" => 'cus_ONqnP40ZzkcUwC',
            "description" => "Test payment from itsolutionstuff.com."
    ]);
    return "done";
    }
}
