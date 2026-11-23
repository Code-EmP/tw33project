@extends('members.layout')

@section('title', $member->name)

@section('content')
@if (session('success'))<p class="alert">{{ session('success') }}</p>@endif
<div class="profile-card">
    <div class="profile-heading"><div class="avatar">{{ strtoupper(substr($member->name, 0, 1)) }}</div><div><p class="eyebrow">Member profile</p><h1>{{ $member->name }}</h1></div></div>
    <div class="details">
        <div><p class="detail-label">Email address</p><p class="detail-value">{{ $member->email }}</p></div>
        <div><p class="detail-label">Membership number</p><p class="detail-value">{{ $member->membership_number }}</p></div>
        <div><p class="detail-label">Status</p><p class="detail-value">{{ $member->is_active ? 'Active' : 'Inactive' }}</p></div>
        <div><p class="detail-label">Category</p><p class="detail-value">{{ $member->membershipCategory?->name ?? $member->category }}</p></div>
        <div><p class="detail-label">Level</p><p class="detail-value">{{ $member->membershipLevel?->name ?? $member->level }}</p></div>
        @if ($member->membershipLevel)<div><p class="detail-label">Membership benefits</p><p class="detail-value">{{ $member->membershipLevel->benefits ?: 'No benefits listed.' }}</p></div><div><p class="detail-label">Validity</p><p class="detail-value">{{ $member->membershipLevel->validity_period }}</p></div>@endif
        <div><p class="detail-label">Joined</p><p class="detail-value">{{ $member->created_at->format('M j, Y') }}</p></div>
    </div>
    <section style="margin-top: 25px; overflow-x: auto;">
        <h2>Transaction history</h2>
        @forelse ($member->membershipTransactions()->with('membershipLevel')->latest()->get() as $transaction)
        <div style="display: grid; grid-template-columns: repeat(5, minmax(120px, 1fr)); gap: 12px; padding: 14px 0; border-bottom: 1px solid var(--line); font-size: .78rem; min-width: 650px;">
            <span><strong>{{ $transaction->transaction_number }}</strong><br>{{ ucfirst($transaction->transaction_type) }}</span>
            <span>{{ $transaction->membershipLevel->name }}<br>₱{{ number_format((float) $transaction->amount, 2) }}</span>
            <span>{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}<br>{{ $transaction->payment_reference }}</span>
            <span>Payment: {{ ucfirst($transaction->payment_status) }}<br>Approval: {{ ucfirst($transaction->approval_status) }}</span>
            <span>{{ $transaction->paid_at?->format('M j, Y g:i A') }}<br>{{ $transaction->expires_at?->format('M j, Y') ?? 'No expiry' }}<br><a href="{{ route('transactions.receipt', $transaction) }}">View receipt</a></span>
        </div>
        @empty
        <p class="muted">No membership transactions recorded.</p>
        @endforelse
    </section>
    <div class="actions">
        <a class="button" href="{{ route('members.edit', $member) }}">Edit details</a>
        @if ($member->is_active)
        <form class="inline" method="POST" action="{{ route('members.deactivate', $member) }}">@csrf @method('PATCH')<button class="button secondary" type="submit">Deactivate</button></form>
        @endif
        <form class="inline" method="POST" action="{{ route('members.destroy', $member) }}" onsubmit="return confirm('Delete this member permanently?')">@csrf @method('DELETE')<button class="button danger" type="submit">Delete</button></form>
    </div>
</div>
@endsection
