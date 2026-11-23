<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipTransaction;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $tasks = Task::query()->when(
            ! $request->user()->isAdmin(),
            fn ($query) => $query->where('user_id', $request->user()->id),
        );
        $totalTasks = (clone $tasks)->count();
        $completedTasks = (clone $tasks)->where('completed', true)->count();
        $pendingTasks = $totalTasks - $completedTasks;
        $completionRate = $totalTasks > 0 ? (int) round(($completedTasks / $totalTasks) * 100) : 0;
        $isAdmin = $request->user()->isAdmin();
        $member = $isAdmin ? null : Member::where('email', $request->user()->email)->first();
        $membershipTransactions = MembershipTransaction::query()->when(
            ! $isAdmin,
            fn ($query) => $query->where('member_id', $member?->id),
        );
        $totalMembers = $isAdmin ? Member::count() : 1;
        $activeMembers = $isAdmin ? Member::where('is_active', true)->count() : (int) ($member?->is_active ?? false);
        $pendingTransactions = (clone $membershipTransactions)->where('approval_status', 'pending')->count();
        $collectedPayments = (float) (clone $membershipTransactions)->where('payment_status', 'paid')->sum('amount');

        return view('dashboard', [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'completionRate' => $completionRate,
            'totalMembers' => $totalMembers,
            'recentTasks' => (clone $tasks)->latest()->limit(5)->get(),
            'isAdmin' => $isAdmin,
            'activeMembers' => $activeMembers,
            'pendingTransactions' => $pendingTransactions,
            'collectedPayments' => $collectedPayments,
        ]);
    }
}
