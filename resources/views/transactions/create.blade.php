<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Record Payment | My Tasks</title>
    <style>body{margin:0;color:#302a3d;background:#f7f4ff;font:15px system-ui,sans-serif}.card{width:min(100% - 32px,620px);margin:45px auto;padding:30px;border:1px solid #e9e3f3;border-radius:18px;background:#fff}h1{margin-top:0}label{display:block;margin:16px 0 7px;font-weight:700}input,select{width:100%;box-sizing:border-box;padding:11px 13px;border:1px solid #ddd6eb;border-radius:9px;font:inherit}.button{margin-top:24px;padding:11px 16px;border:0;border-radius:9px;color:#fff;background:#6048a5;font:inherit;font-weight:700;cursor:pointer}a{color:#6048a5;font-weight:700;text-decoration:none}.muted{color:#817991}.error{color:#a24767;font-size:.8rem}</style>
</head>
<body>
    @include('partials.navigation')
    <main class="card">
        <a href="{{ route('transactions.index') }}">← Transactions</a>
        <h1>Record payment</h1>
        <p class="muted">Create a transaction for a member. Paid transactions can be approved after verification.</p>
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <label for="member_id">Member</label>
            <select id="member_id" name="member_id" required><option value="">Choose a member</option>@foreach ($members as $member)<option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>{{ $member->name }} — {{ $member->membership_number }}</option>@endforeach</select>
            @error('member_id')<p class="error">{{ $message }}</p>@enderror
            <label for="membership_level_id">Membership level</label>
            <select id="membership_level_id" name="membership_level_id" required><option value="">Choose a level</option>@foreach ($levels as $level)<option value="{{ $level->id }}" @selected(old('membership_level_id') == $level->id)>{{ $level->name }} — ₱{{ number_format((float) $level->fee, 2) }}</option>@endforeach</select>
            <label for="transaction_type">Transaction type</label>
            <select id="transaction_type" name="transaction_type" required><option value="new">New membership</option><option value="renewal" @selected(old('transaction_type') === 'renewal')>Renewal</option></select>
            <label for="payment_method">Payment method</label><input id="payment_method" name="payment_method" value="{{ old('payment_method', 'Cash') }}" required>
            <label for="payment_reference">Payment reference</label><input id="payment_reference" name="payment_reference" value="{{ old('payment_reference') }}" placeholder="Receipt or reference number">
            <label for="payment_status">Payment status</label><select id="payment_status" name="payment_status" required><option value="pending">Pending</option><option value="paid" @selected(old('payment_status') === 'paid')>Paid</option></select>
            <button class="button" type="submit">Save payment record</button>
        </form>
    </main>
</body>
</html>
