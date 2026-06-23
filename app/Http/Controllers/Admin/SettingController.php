<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = Setting::all()->pluck('value', 'key');
        $plans    = SubscriptionPlan::orderBy('sort_order')->get();

        return view('admin.settings', compact('settings', 'plans'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jazzcash_number'       => 'required|string|max:20',
            'jazzcash_account_name' => 'required|string|max:255',
            'plan_price.*'          => 'required|numeric|min:0',
        ]);

        // Save JazzCash settings
        Setting::query()->updateOrCreate(['key' => 'jazzcash_number'],       ['value' => $validated['jazzcash_number']]);
        Setting::query()->updateOrCreate(['key' => 'jazzcash_account_name'], ['value' => $validated['jazzcash_account_name']]);

        // Update plan prices directly in subscription_plans
        foreach ($request->input('plan_price', []) as $planId => $price) {
            SubscriptionPlan::where('id', (int) $planId)->update(['price' => $price]);
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
