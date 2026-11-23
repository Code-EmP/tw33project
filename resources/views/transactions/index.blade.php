<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $isAdminView ? 'Transactions' : 'My Transaction History' }} | My Tasks</title>
    <style>
        body { margin: 0; color: #302a3d; background: #f7f4ff; font: 15px system-ui, sans-serif; }
        main { width: min(100% - 32px, 1100px); margin: 0 auto; padding: 45px 0 70px; }
        .heading, .actions, .transaction { display: flex; align-items: center; justify-content: space-between; gap: 18px; }
        .heading { margin-bottom: 25px; }.heading h1 { margin: 0 0 8px; }.muted { color: #817991; }
        .button { display: inline-block; padding: 10px 14px; border-radius: 9px; color: #fff; background: #6048a5; font-weight: 700; text-decoration: none; }
        .secondary { color: #6048a5; background: #eee9ff; }.alert { padding: 14px; border-radius: 10px; color: #6048a5; background: #eee9ff; }
        .list { overflow-x: auto; border: 1px solid #e9e3f3; border-radius: 16px; background: #fff; }.transaction { min-width: 900px; padding: 18px 20px; border-bottom: 1px solid #e9e3f3; align-items: flex-start; }.transaction:last-child { border-bottom: 0; }
        .transaction strong { display: block; margin-bottom: 5px; }.cell { min-width: 130px; font-size: .8rem; }.label { display: block; margin-bottom: 4px; color: #817991; font-size: .7rem; font-weight: 700; text-transform: uppercase; }.status { padding: 5px 8px; border-radius: 99px; color: #6048a5; background: #f7f4ff; font-size: .72rem; font-weight: 700; }.pending { color: #9a6812; background: #fff7df; }.danger { color: #a24767; background: #fff0f5; }.empty { padding: 35px; text-align: center; color: #817991; }
        .pagination { margin-top: 20px; }
    </style>
</head>
<body>
    @include('partials.navigation')
    <main>
        <section class="heading">
            <div><p class="muted">Membership records</p><h1>{{ $isAdminView ? 'Transactions' : 'My transaction history' }}</h1><p class="muted">{{ $isAdminView ? 'Review payments and approve verified transactions.' : 'View your membership payments and receipts.' }}</p></div>
            @if ($isAdminView)<a class="button" href="{{ route('payments.create') }}">Record payment</a>@endif
        </section>
        @if (session('success'))<p class="alert">{{ session('success') }}</p>@endif
        <section class="list">
            @forelse ($transactions as $transaction)
            <article class="transaction">
                <div class="cell"><span class="label">Transaction</span><strong>{{ $transaction->transaction_number }}</strong>{{ ucfirst($transaction->transaction_type) }}</div>
                @if ($isAdminView)<div class="cell"><span class="label">Member</span><strong>{{ $transaction->member->name }}</strong>{{ $transaction->member->membership_number }}</div>@endif
                <div class="cell"><span class="label">Membership</span><strong>{{ $transaction->membershipLevel->name }}</strong>₱{{ number_format((float) $transaction->amount, 2) }}</div>
                <div class="cell"><span class="label">Payment</span><strong>{{ ucfirst($transaction->payment_status) }}</strong>{{ $transaction->payment_reference }}</div>
                <div class="cell"><span class="label">Approval</span><strong><span class="status {{ $transaction->approval_status === 'pending' ? 'pending' : '' }}">{{ ucfirst($transaction->approval_status) }}</span></strong>{{ $transaction->paid_at?->format('M j, Y') ?? 'Not paid' }}</div>
                <div class="actions">
                    <a class="button secondary" href="{{ route('transactions.receipt', $transaction) }}">Receipt</a>
                    @if ($isAdminView && $transaction->approval_status === 'pending' && $transaction->payment_status === 'paid')
                    <form method="POST" action="{{ route('transactions.approve', $transaction) }}">@csrf @method('PATCH')<button class="button" type="submit">Approve</button></form>
                    @endif
                </div>
            </article>
            @empty
            <p class="empty">No transactions recorded yet.</p>
            @endforelse
        </section>
        {{ $transactions->links() }}
    </main>
</body>
</html>
