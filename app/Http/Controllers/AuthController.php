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
use Throwable;

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

        if (! $request->user()->hasVerifiedEmail() && ! $request->user()->isAdmin()) {
            return to_route('verification.notice')->with('status', 'Verify your email address before using your account.');
        }

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
        $request->session()->regenerate();
        $this->deferRegistrationEvent($user);

        return to_route('verification.notice')->with('status', 'Your account is ready. A verification link is being sent to your email.');
    }

    public function resendVerification(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return to_route('dashboard');
        }

        $this->deferVerificationEmail($user);

        return back()->with('status', 'We are trying to send a new verification link. Check your inbox and spam folder shortly.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }

    private function deferVerificationEmail(User $user): void
    {
        defer(function () use ($user): void {
            try {
                $user->sendEmailVerificationNotification();
            } catch (Throwable $exception) {
                report($exception);
            }
        });
    }

    private function deferRegistrationEvent(User $user): void
    {
        defer(function () use ($user): void {
            try {
                event(new Registered($user));
            } catch (Throwable $exception) {
                report($exception);
            }
        });
    }
}
