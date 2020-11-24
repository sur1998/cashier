<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\plan;
use App\User;

class subscriptionController extends Controller
{
    
        protected $stripe;
    
       public function __construct() 
        {
            $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        }
       //\Stripe\Stripe::setApiKey('sk_test_51HqrWnKSLoBeXq07WMU86nOMlGZNZHlA9XyD4Um9wvrKOD0ZXsLFfVtvwJfaMC6Hlm46GXXCWGvDLnIeykgURFpW007JkJRprL');
    
        public function create(Request $request, plan $plan)
        {
           // \Stripe\Stripe::setApiKey('sk_test_51HqrWnKSLoBeXq07WMU86nOMlGZNZHlA9XyD4Um9wvrKOD0ZXsLFfVtvwJfaMC6Hlm46GXXCWGvDLnIeykgURFpW007JkJRprL');
            $plan = plan::findOrFail($request->get('plan'));
            
            $user = $request->user();
            $paymentMethod = $request->paymentMethod;
    
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->newSubscription('default', $plan->stripe_plan)
                ->create($paymentMethod, [
                    'email' => $user->email,
                ]);
            
            return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
        }
    
    
        public function createPlan()
        {
            return view('plan.create');
        }
    
        public function storePlan(Request $request)
        {   
            $data = $request->except('_token');
    
            $data['slug'] = strtolower($data['name']);
            $price = $data['cost'] *100; 
    
            //create stripe product
            $stripeProduct = $this->stripe->products->create([
                'name' => $data['name'],
            ]);
            
            //Stripe Plan Creation
            $stripePlanCreation = $this->stripe->plans->create([
                'amount' => $price,
                'currency' => 'inr',
                'interval' => 'month', //  it can be day,week,month or year
                'product' => $stripeProduct->id,
            ]);
    
            $data['stripe_plan'] = $stripePlanCreation->id;
    
            plan::create($data);
    
            echo 'plan has been created';
        }
    }

