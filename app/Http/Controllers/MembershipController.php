<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function index(Request $request): View
    {
        return view('membership.page', [
            'levels' => MembershipLevel::where('is_active', true)->orderBy('fee')->limit(4)->get(),
            'member' => $this->memberFor($request),
            'checkoutLevel' => $request->filled('checkout')
                ? MembershipLevel::where('is_active', true)->findOrFail($request->integer('checkout'))
                : null,
        ]);
    }

    public function checkout(Request $request, MembershipLevel $level): View
    {
        abort_unless($level->is_active, 404);

        return view('membership.checkout-modal', [
            'level' => $level,
            'levels' => MembershipLevel::where('is_active', true)->orderBy('fee')->limit(4)->get(),
        ]);
    }

    public function purchase(Request $request, MembershipLevel $level): RedirectResponse
    {
        abort_unless($level->is_active, 404);
        $validated = $request->validate([
            'payment_method' => ['required', 'in:demo_card,demo_wallet'],
        ]);
        $member = $this->memberFor($request);

        DB::transaction(function () use ($member, $level, $validated): void {
            $latestTransaction = $member->membershipTransactions()
                ->where('approval_status', 'approved')
                ->latest('approved_at')
                ->first();
            $startsAt = $latestTransaction?->expires_at?->isFuture()
                ? $latestTransaction->expires_at->copy()
                : now();
            $expiresAt = $level->validity_period === 'Forever'
                ? null
                : Carbon::parse($startsAt)->modify('+'.$level->validity_period);

            $transaction = MembershipTransaction::create([
                'member_id' => $member->id,
                'membership_level_id' => $level->id,
                'transaction_type' => $latestTransaction === null ? 'new' : 'renewal',
                'amount' => $level->fee,
                'payment_method' => $validated['payment_method'],
                'payment_reference' => 'DEMO-'.str()->upper(str()->random(10)),
                'starts_at' => $startsAt,
                'expires_at' => $expiresAt,
            ]);
            $transaction->markPaid();
            $transaction->approve();

            $member->update([
                'level' => $level->name,
                'membership_level_id' => $level->id,
                'is_active' => true,
            ]);
        });

        return to_route('profile')->with('success', $level->name.' membership transaction completed successfully.');
    }

    public function unsubscribe(Request $request): RedirectResponse
    {
        $this->memberFor($request)->update(['is_active' => false]);

        return to_route('profile')->with('success', 'Your membership has been unsubscribed.');
    }

    private function memberFor(Request $request): Member
    {
        return Member::firstOrCreate(
            ['email' => $request->user()->email],
            [
                'name' => $request->user()->name,
                'category' => 'General',
                'level' => 'Basic',
                'is_active' => true,
            ],
        );
    }
}
