<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = plan::all();
        return view('plan.index', compact('plans'));
    }
    public function show(plan $plan, Request $request)
    {   
        $paymentMethods = $request->user()->paymentMethods();

        $intent = $request->user()->createSetupIntent();
        
        return view('plan.show', compact('plan', 'intent'));
    }
}
