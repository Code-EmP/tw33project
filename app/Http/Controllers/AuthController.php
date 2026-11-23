<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Those credentials do not match our records.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return to_route('dashboard');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create($validated);
        $category = MembershipCategory::firstOrCreate(
            ['name' => 'General'],
            ['description' => 'Default member category', 'is_active' => true],
        );
        $level = MembershipLevel::firstOrCreate(
            ['name' => 'Basic'],
            ['fee' => 0, 'validity_period' => 'Forever', 'benefits' => 'Access to the core workspace', 'is_active' => true],
        );
        Member::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'category' => $category->name,
            'level' => $level->name,
            'membership_category_id' => $category->id,
            'membership_level_id' => $level->id,
        ]);
        Auth::login($user);
        event(new Registered($user));
        $request->session()->regenerate();

        return to_route('verification.notice');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
