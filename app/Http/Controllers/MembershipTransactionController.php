<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipTransactionController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = MembershipTransaction::query()
            ->with(['member', 'membershipLevel'])
            ->when(! $request->user()->isAdmin(), function ($query) use ($request): void {
                $query->where('member_id', $this->memberFor($request)->id);
            })
            ->latest()
            ->paginate(15);

        return view('transactions.index', [
            'transactions' => $transactions,
            'isAdminView' => $request->user()->isAdmin(),
        ]);
    }

    public function create(): View
    {
        return view('transactions.create', [
            'members' => Member::orderBy('name')->get(),
            'levels' => MembershipLevel::where('is_active', true)->orderBy('fee')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'membership_level_id' => ['required', 'exists:membership_levels,id'],
            'transaction_type' => ['required', 'in:new,renewal'],
            'payment_method' => ['required', 'string', 'max:100'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
            'payment_status' => ['required', 'in:pending,paid'],
        ]);
        $level = MembershipLevel::findOrFail($validated['membership_level_id']);

        $transaction = MembershipTransaction::create([
            ...$validated,
            'amount' => $level->fee,
            'payment_reference' => $validated['payment_reference'] ?? 'ADMIN-'.str()->upper(str()->random(10)),
        ]);

        if ($validated['payment_status'] === 'paid') {
            $transaction->markPaid();
        }

        return to_route('transactions.index')->with('success', 'Payment record saved. Approve it after verifying the payment.');
    }

    public function approve(MembershipTransaction $transaction): RedirectResponse
    {
        abort_unless($transaction->payment_status === 'paid', 422, 'Only paid transactions may be approved.');
        abort_if($transaction->approval_status === 'approved', 422, 'This transaction is already approved.');
        $latestTransaction = MembershipTransaction::query()
            ->where('member_id', $transaction->member_id)
            ->where('approval_status', 'approved')
            ->latest('approved_at')
            ->first();
        $startsAt = $latestTransaction?->expires_at?->isFuture()
            ? $latestTransaction->expires_at->copy()
            : now();
        $expiresAt = $transaction->membershipLevel->validity_period === 'Forever'
            ? null
            : Carbon::parse($startsAt)->modify('+'.$transaction->membershipLevel->validity_period);

        $transaction->update(['starts_at' => $startsAt, 'expires_at' => $expiresAt]);
        $transaction->approve();
        $transaction->member->update([
            'level' => $transaction->membershipLevel->name,
            'membership_level_id' => $transaction->membership_level_id,
            'is_active' => true,
        ]);

        return to_route('transactions.index')->with('success', 'Paid transaction approved.');
    }

    public function receipt(Request $request, MembershipTransaction $transaction): View
    {
        abort_unless(
            $request->user()->isAdmin() || $transaction->member->email === $request->user()->email,
            403,
        );

        return view('transactions.receipt', compact('transaction'));
    }

    private function memberFor(Request $request): Member
    {
        return Member::where('email', $request->user()->email)->firstOrFail();
    }
}
