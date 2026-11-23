<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt {{ $transaction->transaction_number }} | My Tasks</title>
    <style>body{margin:0;color:#302a3d;background:#f7f4ff;font:15px system-ui,sans-serif}.receipt{width:min(100% - 32px,620px);margin:55px auto;padding:34px;border:1px solid #e9e3f3;background:#fff;box-shadow:0 14px 35px #6048a512}.top{display:flex;justify-content:space-between;gap:20px;border-bottom:2px solid #6048a5;padding-bottom:20px}.muted{color:#817991}.row{display:flex;justify-content:space-between;gap:20px;padding:14px 0;border-bottom:1px solid #e9e3f3}.total{font-size:1.3rem;font-weight:800;color:#6048a5}.actions{display:flex;gap:10px;margin-top:25px}.button{padding:11px 15px;border:0;border-radius:9px;color:#fff;background:#6048a5;font:inherit;font-weight:700;text-decoration:none;cursor:pointer}.secondary{color:#6048a5;background:#eee9ff}@media print{body{background:#fff}.receipt{width:100%;margin:0;border:0;box-shadow:none}.actions{display:none}}</style>
</head>
<body>
    <main class="receipt">
        <header class="top"><div><p class="muted">My Tasks</p><h1>Membership receipt</h1></div><strong>{{ $transaction->transaction_number }}</strong></header>
        <p class="muted">Issued {{ $transaction->paid_at?->format('F j, Y g:i A') ?? $transaction->created_at->format('F j, Y g:i A') }}</p>
        <div class="row"><span>Member</span><strong>{{ $transaction->member->name }}</strong></div>
        <div class="row"><span>Membership number</span><strong>{{ $transaction->member->membership_number }}</strong></div>
        <div class="row"><span>Membership level</span><strong>{{ $transaction->membershipLevel->name }}</strong></div>
        <div class="row"><span>Transaction type</span><strong>{{ ucfirst($transaction->transaction_type) }}</strong></div>
        <div class="row"><span>Payment method</span><strong>{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</strong></div>
        <div class="row"><span>Payment reference</span><strong>{{ $transaction->payment_reference }}</strong></div>
        <div class="row total"><span>Total paid</span><strong>₱{{ number_format((float) $transaction->amount, 2) }}</strong></div>
        <div class="row"><span>Status</span><strong>{{ ucfirst($transaction->payment_status) }} / {{ ucfirst($transaction->approval_status) }}</strong></div>
        <div class="actions"><button class="button" type="button" onclick="window.print()">Print receipt</button><a class="button secondary" href="{{ route('transactions.index') }}">Back to transactions</a></div>
    </main>
</body>
</html>
