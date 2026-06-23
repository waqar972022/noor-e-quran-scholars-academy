<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('user.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        auth()->user()->update($request->only('name', 'phone'));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update(['password' => $request->input('password')]);

        return back()->with('success', 'Password updated successfully.');
    }
}
