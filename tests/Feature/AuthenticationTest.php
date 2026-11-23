<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

test('a user can register as a member', function () {
    Notification::fake();

    $response = $this->post(route('register.store'), [
        'name' => 'New Member',
        'email' => 'member@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirectToRoute('verification.notice');
    expect(User::first()->role)->toBe('member');
    expect(Member::first()->level)->toBe('Basic');
    Notification::assertCount(1);
});

test('a user can verify their email with the signed link', function () {
    $user = User::factory()->unverified()->create();
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(10),
        ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())],
    );

    $this->actingAs($user)->get($verificationUrl)->assertRedirectToRoute('dashboard');

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

test('an unverified existing user can log in without being blocked', function () {
    $user = User::factory()->unverified()->create([
        'email' => 'unverified@example.com',
        'password' => 'password',
    ]);

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirectToRoute('dashboard');

    $this->get(route('dashboard'))->assertOk();
});

test('a member cannot access admin management', function () {
    $member = User::factory()->create(['role' => 'member']);

    $response = $this->actingAs($member)->get(route('members.index'));

    $response->assertForbidden();
});

test('an admin can access member management', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('members.index'));

    $response->assertOk();
});

test('an authenticated user can log out', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirectToRoute('login');
    $this->assertGuest();
});
