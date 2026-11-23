<?php

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use App\Models\User;

test('a membership purchase creates a paid approved transaction with a membership number', function () {
    $user = User::factory()->create();
    $category = MembershipCategory::create(['name' => 'Test Regular', 'description' => null, 'is_active' => true]);
    $level = MembershipLevel::create([
        'name' => 'Test Gold', 'fee' => 900, 'validity_period' => '1 year',
        'benefits' => 'Priority access', 'is_active' => true,
    ]);
    $member = Member::create([
        'name' => $user->name, 'email' => $user->email, 'category' => $category->name,
        'level' => 'Basic', 'membership_category_id' => $category->id,
        'membership_level_id' => $level->id,
    ]);

    $this->actingAs($user)
        ->post(route('membership.purchase', $level), ['payment_method' => 'demo_card'])
        ->assertRedirect(route('profile'));

    expect($member->fresh()->membership_number)->toStartWith('MBR-');
    $transaction = MembershipTransaction::first();
    expect($transaction->transaction_type)->toBe('new')
        ->and($transaction->payment_status)->toBe('paid')
        ->and($transaction->approval_status)->toBe('approved');
});

test('a later membership purchase is recorded as a renewal', function () {
    $user = User::factory()->create();
    $category = MembershipCategory::create(['name' => 'Test Renewal', 'is_active' => true]);
    $level = MembershipLevel::create([
        'name' => 'Test Renewal Level', 'fee' => 900, 'validity_period' => '1 year', 'is_active' => true,
    ]);
    Member::create([
        'name' => $user->name, 'email' => $user->email, 'category' => $category->name,
        'level' => $level->name, 'membership_category_id' => $category->id,
        'membership_level_id' => $level->id,
    ]);

    $this->actingAs($user)->post(route('membership.purchase', $level), ['payment_method' => 'demo_wallet']);
    $this->actingAs($user)->post(route('membership.purchase', $level), ['payment_method' => 'demo_wallet']);

    expect(MembershipTransaction::query()->pluck('transaction_type')->all())->toBe(['new', 'renewal']);
});

test('unpaid transactions cannot be approved', function () {
    $transaction = MembershipTransaction::create([
        'member_id' => Member::create([
            'name' => 'Test Member', 'email' => 'test@example.com', 'category' => 'Test', 'level' => 'Test Basic',
        ])->id,
        'membership_level_id' => MembershipLevel::create([
            'name' => 'Test Basic', 'fee' => 0, 'validity_period' => 'Forever', 'is_active' => true,
        ])->id,
        'transaction_type' => 'new', 'amount' => 0, 'payment_method' => 'demo_card',
    ]);

    expect(fn () => $transaction->approve())->toThrow(LogicException::class);
});

test('an admin can remove a membership level without purchase history', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $level = MembershipLevel::create([
        'name' => 'Removable Level',
        'fee' => 100,
        'validity_period' => '1 month',
        'is_active' => true,
    ]);

    $this->actingAs($admin)
        ->delete(route('membership-settings.levels.destroy', $level))
        ->assertRedirect(route('membership-settings.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('membership_levels', ['id' => $level->id]);
});

test('a membership level with purchase history cannot be removed', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $level = MembershipLevel::create([
        'name' => 'Protected Level',
        'fee' => 100,
        'validity_period' => '1 month',
        'is_active' => true,
    ]);
    MembershipTransaction::create([
        'member_id' => Member::create([
            'name' => 'Protected Member',
            'email' => 'protected@example.com',
            'category' => 'Test',
            'level' => $level->name,
        ])->id,
        'membership_level_id' => $level->id,
        'transaction_type' => 'new',
        'amount' => 100,
        'payment_method' => 'demo_card',
        'payment_status' => 'paid',
        'approval_status' => 'approved',
    ]);

    $this->actingAs($admin)
        ->delete(route('membership-settings.levels.destroy', $level))
        ->assertRedirect(route('membership-settings.index'))
        ->assertSessionHas('error');

    $this->assertDatabaseHas('membership_levels', ['id' => $level->id]);
});

test('an admin can record and approve a paid transaction', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $member = Member::create([
        'name' => 'Recorded Member', 'email' => 'recorded@example.com', 'category' => 'Test', 'level' => 'Basic',
    ]);
    $level = MembershipLevel::create([
        'name' => 'Recorded Level', 'fee' => 250, 'validity_period' => '1 month', 'is_active' => true,
    ]);

    $this->actingAs($admin)->post(route('payments.store'), [
        'member_id' => $member->id,
        'membership_level_id' => $level->id,
        'transaction_type' => 'new',
        'payment_method' => 'Cash',
        'payment_status' => 'paid',
    ])->assertRedirectToRoute('transactions.index');

    $transaction = MembershipTransaction::firstOrFail();
    expect($transaction->approval_status)->toBe('pending');

    $this->actingAs($admin)->patch(route('transactions.approve', $transaction))
        ->assertRedirectToRoute('transactions.index');

    expect($transaction->fresh()->approval_status)->toBe('approved')
        ->and($member->fresh()->membership_level_id)->toBe($level->id);
});

test('members can only view their own transaction history and receipts', function () {
    $firstUser = User::factory()->create();
    $secondUser = User::factory()->create();
    $firstMember = Member::create([
        'name' => $firstUser->name, 'email' => $firstUser->email, 'category' => 'Test', 'level' => 'Basic',
    ]);
    $secondMember = Member::create([
        'name' => $secondUser->name, 'email' => $secondUser->email, 'category' => 'Test', 'level' => 'Basic',
    ]);
    $level = MembershipLevel::create([
        'name' => 'History Level', 'fee' => 100, 'validity_period' => '1 month', 'is_active' => true,
    ]);
    $transaction = MembershipTransaction::create([
        'member_id' => $secondMember->id, 'membership_level_id' => $level->id, 'transaction_type' => 'new',
        'amount' => 100, 'payment_method' => 'Cash', 'payment_status' => 'paid',
    ]);

    $this->actingAs($firstUser)->get(route('transactions.index'))->assertOk()->assertDontSee($transaction->transaction_number);
    $this->actingAs($firstUser)->get(route('transactions.receipt', $transaction))->assertForbidden();
    expect($firstMember->membership_number)->not->toBe($secondMember->membership_number);
});
