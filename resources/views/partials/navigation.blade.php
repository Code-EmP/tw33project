<link rel="stylesheet" href="{{ asset('css/site.css') }}">
<script src="{{ asset('js/site.js') }}" defer></script>
<style>
    .site-header { position: sticky; z-index: 20; top: 0; display: flex; align-items: center; justify-content: space-between; min-height: 68px; padding: 0 clamp(20px, 5vw, 72px); color: #fff; background: rgb(63 45 120 / 96%); box-shadow: 0 8px 24px rgb(48 42 61 / 13%); backdrop-filter: blur(16px); }
    .site-brand { display: flex; align-items: center; gap: 10px; color: #fff; font-weight: 850; letter-spacing: -.04em; text-decoration: none; }
    .site-mark { display: grid; width: 34px; height: 34px; place-items: center; border: 1px solid rgb(255 255 255 / 45%); border-radius: 11px; color: #3f2d78; background: #fff; box-shadow: 0 5px 14px rgb(31 22 70 / 15%); font-size: .82rem; }
    .site-nav { display: flex; align-items: center; gap: 3px; margin-left: auto; }
    .site-nav a { padding: 9px 12px; border-radius: 9px; color: #ebe7fa; font-size: .82rem; font-weight: 700; text-decoration: none; }
    .site-nav a:hover, .site-nav a.active { color: #3f2d78; background: #fff; box-shadow: 0 5px 14px rgb(31 22 70 / 10%); }
    .site-profile { display: grid; width: 34px; height: 34px; place-items: center; margin-left: 14px; border: 1px solid #c8bff1; border-radius: 50%; color: #fff; background: rgb(255 255 255 / 8%); font-size: .72rem; font-weight: 800; text-decoration: none; }
    .site-profile:hover { background: #fff; color: #3f2d78; }
    .site-logout { margin-left: 8px; padding: 9px 12px; border: 1px solid rgb(255 255 255 / 24%); border-radius: 9px; color: #fff; background: transparent; font: inherit; font-size: .78rem; font-weight: 700; cursor: pointer; }
    .site-logout:hover { color: #3f2d78; background: #fff; }
    .admin-menu { position: relative; }
    .admin-toggle { display: flex; align-items: center; gap: 7px; padding: 9px 12px; border: 0; border-radius: 9px; color: #ebe7fa; background: transparent; font: inherit; font-size: .82rem; font-weight: 700; cursor: pointer; list-style: none; }
    .admin-toggle::-webkit-details-marker { display: none; }
    .admin-toggle::after { width: 6px; height: 6px; margin-top: -3px; border-right: 1.5px solid currentColor; border-bottom: 1.5px solid currentColor; content: ""; transform: rotate(45deg); transition: transform 180ms ease; }
    .admin-menu[open] .admin-toggle, .admin-toggle:hover { color: #3f2d78; background: #fff; box-shadow: 0 5px 14px rgb(31 22 70 / 10%); }
    .admin-menu[open] .admin-toggle::after { margin-top: 3px; transform: rotate(225deg); }
    .admin-dropdown { position: absolute; z-index: 30; top: calc(100% + 10px); right: 0; width: 210px; padding: 7px; border: 1px solid var(--site-line); border-radius: 12px; background: #fff; box-shadow: 0 16px 38px rgb(48 42 61 / 18%); }
    .admin-menu[open] .admin-dropdown { animation: admin-menu-enter 180ms ease-out both; transform-origin: top right; }
    .admin-menu[open] .admin-dropdown a { animation: admin-item-enter 220ms ease-out both; }
    .admin-menu[open] .admin-dropdown a:nth-child(2) { animation-delay: 45ms; }
    @keyframes admin-menu-enter {
        from { opacity: 0; transform: translateY(-6px) scale(.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes admin-item-enter {
        from { opacity: 0; transform: translateX(5px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .admin-dropdown a { display: block; padding: 10px 11px; border-radius: 8px; color: var(--site-muted); font-size: .79rem; }
    .admin-dropdown a:hover, .admin-dropdown a.active { color: var(--site-purple); background: var(--site-lavender); box-shadow: none; }
    .task-page .site-header { margin: -48px -20px 30px; }
    @media (max-width: 760px) { .site-header { min-height: 62px; overflow-x: visible; padding: 0 16px; }.site-brand span:last-child { display: none; }.site-nav { gap: 0; }.site-nav a, .admin-toggle { padding: 8px 7px; font-size: .72rem; }.site-profile, .site-logout { display: none; }.admin-dropdown { position: fixed; top: 58px; right: 12px; } }
    @media (prefers-reduced-motion: reduce) {
        .admin-menu[open] .admin-dropdown,
        .admin-menu[open] .admin-dropdown a,
        .admin-toggle::after { animation: none; transition: none; }
    }
</style>
<header class="site-header">
    <a class="site-brand" href="{{ route('dashboard') }}"><span class="site-mark">T</span><span>My Tasks</span></a>
    <nav class="site-nav" aria-label="Main navigation">
        <a class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}">Tasks</a>
        <a class="{{ request()->routeIs('membership.*') ? 'active' : '' }}" href="{{ route('membership.index') }}">Membership</a>
        <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
        @if (auth()->user()->isAdmin())
        <details class="admin-menu" {{ request()->routeIs('members.*', 'membership-settings.*', 'transactions.*', 'payments.*') ? 'open' : '' }}>
            <summary class="admin-toggle" aria-label="Admin menu">Admin</summary>
            <div class="admin-dropdown">
                <a class="{{ request()->routeIs('members.*') ? 'active' : '' }}" href="{{ route('members.index') }}">Members</a>
                <a class="{{ request()->routeIs('membership-settings.*') ? 'active' : '' }}" href="{{ route('membership-settings.index') }}">Category / levels management</a>
                <a class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">Transactions</a>
                <a class="{{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.create') }}">Record payment</a>
            </div>
        </details>
        @else
        <a class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">Transactions</a>
        @endif
    </nav>
    <a class="site-profile" href="{{ route('profile') }}">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</a>
    <form method="POST" action="{{ route('logout') }}">@csrf<button class="site-logout" type="submit">Log out</button></form>
</header>
