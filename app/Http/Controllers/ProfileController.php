<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        return view($request->user()->profile_completed && ! $request->boolean('edit') ? 'profile.show' : 'profile.edit', [
            'member' => Member::where('email', $request->user()->email)->firstOrFail(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:1000'],
            'age' => ['required', 'integer', 'min:13', 'max:120'],
            'location' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->update($validated + ['profile_completed' => true]);
        Member::where('email', $request->user()->email)->update(['name' => $validated['name']]);

        return to_route('profile')->with('success', 'Profile updated successfully.');
    }
}
