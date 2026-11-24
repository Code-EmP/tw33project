<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Membership checkout | My Tasks</title>
    <style>
        :root { --ink: #302a3d; --muted: #817991; --line: #e9e3f3; --lavender: #f7f4ff; --purple: #6048a5; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: var(--ink); background: var(--lavender); font: 15px system-ui, sans-serif; }
        main { width: min(100% - 32px, 980px); margin: 0 auto; padding: 45px 0 70px; }
        .back { color: var(--purple); font-weight: 700; text-decoration: none; }
        h1 { margin: 26px 0 7px; font-size: clamp(2rem, 5vw, 2.7rem); letter-spacing: -.05em; }
        .muted { color: var(--muted); line-height: 1.6; }
        .checkout { display: grid; grid-template-columns: 1.25fr .75fr; gap: 20px; margin-top: 28px; }
        .panel { padding: 25px; border: 1px solid var(--line); border-radius: 18px; background: #fff; box-shadow: 0 12px 34px rgb(96 72 165 / 7%); }
        h2 { margin: 0 0 17px; font-size: 1.1rem; }
        .methods { display: grid; gap: 11px; }
        .method { display: flex; align-items: center; gap: 13px; min-height: 76px; padding: 13px 15px; border: 1px solid var(--line); border-radius: 13px; cursor: pointer; transition: .16s ease; }
        .method:hover { border-color: #b7a9db; }
        .method:has(input:checked) { border-color: var(--purple); background: #faf8ff; box-shadow: 0 0 0 3px rgb(96 72 165 / 10%); }
        .method input { margin: 0; accent-color: var(--purple); }
        .icon { display: grid; flex: 0 0 42px; width: 42px; height: 42px; place-items: center; border-radius: 11px; color: white; font-weight: 850; font-size: 1.1rem; }
        .gcash { background: #0877e8; }.card-icon { color: #58469a; border: 1px solid #e4def1; background: linear-gradient(145deg, #fff, #f0ebfc); }.paypal { background: #173c77; font-style: italic; }
        .method-name { font-weight: 750; }.method-note { display: block; margin-top: 3px; color: var(--muted); font-size: .78rem; font-weight: 450; }
        .summary { background: linear-gradient(150deg, #fff, #faf8ff); }.row { display: flex; justify-content: space-between; gap: 12px; padding: 14px 0; border-bottom: 1px solid var(--line); }.total { color: var(--purple); font-size: 1.2rem; font-weight: 800; }
        .notice { margin: 17px 0 0; padding: 12px 14px; border-radius: 11px; color: #685625; background: #fff8e6; font-size: .8rem; line-height: 1.55; }
        .button { width: 100%; margin-top: 20px; padding: 13px 16px; border: 0; border-radius: 10px; color: #fff; background: var(--purple); font: inherit; font-weight: 750; cursor: pointer; }
        .button:hover { background: #503b91; }
        @media (max-width: 720px) { .checkout { grid-template-columns: 1fr; }.summary { order: -1; } }
    </style>
</head>
<body>
    @include('partials.navigation')
    <main>
        <a class="back" href="{{ route('membership.index') }}">← Back to memberships</a>
        <h1>Membership checkout</h1>
        <p class="muted">Choose a payment method for your {{ $level->name }} membership.</p>
        <form method="POST" action="{{ route('membership.purchase', $level) }}" class="checkout">
            @csrf
            <section class="panel">
                <h2>Payment method</h2>
                <div class="methods">
                    <label class="method"><input type="radio" name="payment_method" value="GCash" checked><span class="icon gcash" aria-hidden="true">G</span><span><span class="method-name">GCash</span><small class="method-note">E-wallet</small></span></label>
                    <label class="method"><input type="radio" name="payment_method" value="Card"><span class="icon card-icon" aria-hidden="true"><svg width="24" height="20" viewBox="0 0 24 20" fill="none"><rect x="1" y="1" width="22" height="18" rx="3" stroke="currentColor" stroke-width="1.7"/><path d="M2 7h20M5 14h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><span><span class="method-name">Card</span><small class="method-note">Credit or debit</small></span></label>
                    <label class="method"><input type="radio" name="payment_method" value="PayPal"><span class="icon paypal" aria-hidden="true">P</span><span><span class="method-name">PayPal</span><small class="method-note">Online wallet</small></span></label>
                </div>
                <p class="notice">Simulated checkout for your project demonstration. No real payment is taken; continuing records a sample transaction.</p>
                <button class="button" type="submit">Continue</button>
            </section>
            <aside class="panel summary">
                <h2>Order summary</h2>
                <div class="row"><span>{{ $level->name }} membership</span><strong>₱{{ number_format((float) $level->fee, 2) }}</strong></div>
                <div class="row"><span>Billing period</span><span>{{ $level->validity_period }}</span></div>
                <div class="row total"><span>Total</span><span>₱{{ number_format((float) $level->fee, 2) }}</span></div>
                <p class="muted">{{ $level->benefits ?: 'Membership benefits included.' }}</p>
            </aside>
        </form>
    </main>
</body>
</html>