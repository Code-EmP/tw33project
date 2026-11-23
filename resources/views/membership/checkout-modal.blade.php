<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout | My Tasks</title>
    <style>
        :root { --ink: #302a3d; --muted: #817991; --line: #e9e3f3; --lavender: #f7f4ff; --purple: #6048a5; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: var(--lavender); font: 15px system-ui, sans-serif; }
        .background { width: min(100% - 32px, 1100px); margin: 0 auto; padding: 55px 0; filter: blur(6px); opacity: .7; pointer-events: none; }
        .background-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 35px; }
        .plan { min-height: 245px; padding: 24px; border: 1px solid var(--line); border-radius: 18px; background: #fff; }
        .plan p { color: var(--muted); line-height: 1.6; }
        .price { color: var(--purple); font-size: 2rem; font-weight: 800; }
        .backdrop { position: fixed; z-index: 5; inset: 0; display: grid; overflow-y: auto; place-items: center; padding: 24px; background: rgb(48 42 61 / 32%); }
        .modal { width: min(100%, 920px); border: 1px solid var(--line); border-radius: 20px; background: #fff; box-shadow: 0 24px 70px rgb(48 42 61 / 25%); }
        .modal-header { display: flex; align-items: center; justify-content: space-between; padding: 22px 28px; color: #fff; border-radius: 19px 19px 0 0; background: linear-gradient(110deg, #6048a5, #8068c4); }
        .modal-header h1 { margin: 0; font-size: 1.6rem; }.close { color: #fff; font-size: 1.5rem; text-decoration: none; }
        .checkout-grid { display: grid; grid-template-columns: 1.3fr .7fr; gap: 24px; padding: 28px; }
        .section, .summary { padding: 20px; border: 1px solid var(--line); border-radius: 14px; }.section h2, .summary h2 { margin: 0 0 18px; color: var(--purple); font-size: 1.1rem; }
        label { display: block; margin: 14px 0 7px; font-weight: 700; }input { width: 100%; padding: 11px; border: 1px solid #ddd6eb; border-radius: 9px; font: inherit; }
        .payment { display: grid; gap: 10px; }.payment label { display: flex; align-items: center; gap: 9px; margin: 0; padding: 13px; border: 1px solid var(--line); border-radius: 10px; font-weight: 600; }.payment input { width: auto; }
        .summary { background: var(--lavender); }.summary-row { display: flex; justify-content: space-between; gap: 15px; padding: 12px 0; border-bottom: 1px solid var(--line); }.total { color: var(--purple); font-size: 1.4rem; font-weight: 800; }
        .button { width: 100%; margin-top: 22px; padding: 12px; border: 0; border-radius: 10px; color: #fff; background: var(--purple); font: inherit; font-weight: 700; cursor: pointer; }.muted { color: var(--muted); line-height: 1.6; }
        @media (max-width: 850px) { .background-grid { grid-template-columns: repeat(2, 1fr); }.checkout-grid { grid-template-columns: 1fr; } }@media (max-width: 500px) { .background-grid { grid-template-columns: 1fr; }.checkout-grid { padding: 18px; }.backdrop { padding: 12px; } }
    </style>
</head>
<body>
    @include('partials.navigation')
    <main class="background"><a href="{{ route('dashboard') }}">← Dashboard</a><h1>Choose your membership</h1><p class="muted">Upgrade your workspace membership.</p><section class="background-grid">@foreach ($levels as $membership)<article class="plan"><h2>{{ $membership->name }}</h2><div class="price">₱{{ number_format((float) $membership->fee, 2) }}</div><p>{{ $membership->benefits }}</p></article>@endforeach</section></main>
    <div class="backdrop" role="dialog" aria-modal="true" aria-labelledby="checkout-title">
        <section class="modal">
            <header class="modal-header"><h1 id="checkout-title">Checkout</h1><a class="close" href="{{ route('membership.index') }}" aria-label="Close checkout">×</a></header>
            <form method="POST" action="{{ route('membership.purchase', $level) }}">
                @csrf
                <div class="checkout-grid">
                    <div>
                        <section class="section"><h2>Customer Information</h2><label for="customer_name">Full name</label><input id="customer_name" value="{{ auth()->user()->name }}" required><label for="customer_email">Email address</label><input id="customer_email" type="email" value="{{ auth()->user()->email }}" required></section>
                        <section class="section" style="margin-top: 18px"><h2>Payment Method</h2><div class="payment"><label><input type="radio" name="payment_method" value="demo_card" checked> Demo credit/debit card</label><label><input type="radio" name="payment_method" value="demo_wallet"> Demo e-wallet</label></div><p class="muted">This is a demo checkout. No real payment will be processed.</p></section>
                    </div>
                    <aside class="summary"><h2>Order Summary</h2><div class="summary-row"><span>{{ $level->name }} membership</span><strong>₱{{ number_format((float) $level->fee, 2) }}</strong></div><div class="summary-row"><span>Billing period</span><span>{{ $level->validity_period }}</span></div><div class="summary-row total"><span>Total</span><span>₱{{ number_format((float) $level->fee, 2) }}</span></div><button class="button" type="submit">Complete demo purchase</button></aside>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
