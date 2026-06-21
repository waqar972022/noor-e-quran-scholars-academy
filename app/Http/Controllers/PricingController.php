<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\View\View;

class PricingController extends Controller
{
    public function __invoke(): View
    {
        $plans = SubscriptionPlan::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        return view('pricing', compact('plans'));
    }
}
