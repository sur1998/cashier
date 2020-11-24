<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {   
        // Enter Your Stripe Secret
        \Stripe\Stripe::setApiKey('sk_test_51HqrWnKSLoBeXq07WMU86nOMlGZNZHlA9XyD4Um9wvrKOD0ZXsLFfVtvwJfaMC6Hlm46GXXCWGvDLnIeykgURFpW007JkJRprL');
        		
		$amount = 1000;
		$amount *= 100;
        $amount = (int) $amount;
        
        $payment_intent = \Stripe\PaymentIntent::create([
			'description' => 'Payment',
			'amount' => $amount,
			'currency' => 'INR',
			'description' => 'Payment From user',
			'payment_method_types' => ['card'],
		]);
		$intent = $payment_intent->client_secret;

		return view('checkout.credit-card',compact('intent'));

    }

    public function afterPayment()
    {
        echo 'Payment Has been Received';
    }
}