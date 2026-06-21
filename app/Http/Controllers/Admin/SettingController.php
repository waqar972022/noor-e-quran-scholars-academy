<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jazzcash_number'       => 'required|string|max:20',
            'jazzcash_account_name' => 'required|string|max:255',
            'basic_plan_price'      => 'required|numeric|min:0',
            'standard_plan_price'   => 'required|numeric|min:0',
            'premium_plan_price'    => 'required|numeric|min:0',
        ]);

        foreach ($validated as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
