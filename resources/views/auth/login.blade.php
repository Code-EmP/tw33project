<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in | My Tasks</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <style>
        :root { color-scheme: light; --ink:#302a3d; --muted:#817991; --line:#e9e3f3; --purple:#6048a5; --lavender:#f7f4ff; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; display:grid; place-items:center; overflow:hidden; color:var(--ink); background:radial-gradient(circle at 15% 15%,#ede7ff 0,transparent 28%),radial-gradient(circle at 85% 85%,#e9e2ff 0,transparent 30%),var(--lavender); font:15px Inter,ui-sans-serif,system-ui,sans-serif; }
        body::before,body::after { position:fixed; width:260px; height:260px; border:1px solid rgb(96 72 165 / 10%); border-radius:50%; content:""; }
        body::before { top:-155px; right:-80px; box-shadow:0 0 0 38px rgb(96 72 165 / 3%); }
        body::after { bottom:-180px; left:-70px; box-shadow:0 0 0 48px rgb(96 72 165 / 3%); }
        .card { position:relative; width:min(calc(100% - 32px),420px); padding:38px; border:1px solid rgb(233 227 243 / 90%); border-radius:24px; background:rgb(255 255 255 / 92%); box-shadow:0 24px 60px rgb(96 72 165 / 14%); animation:enter .45s ease-out both; }
        .brand { display:inline-flex; align-items:center; gap:9px; color:var(--purple); font-weight:850; letter-spacing:-.03em; text-decoration:none; }
        .brand-mark { display:grid; width:32px; height:32px; place-items:center; border-radius:10px; color:#fff; background:var(--purple); }
        h1 { margin:28px 0 8px; font-size:2.15rem; letter-spacing:-.06em; }
        p { color:var(--muted); line-height:1.6; }
        .field { margin:18px 0; }
        label { display:block; margin-bottom:7px; font-size:.84rem; font-weight:750; }
        input { width:100%; padding:12px 13px; border:1px solid #ddd6eb; border-radius:10px; outline:0; background:#fff; font:inherit; transition:.16s ease; }
        input:focus { border-color:#9a84df; box-shadow:0 0 0 4px rgb(139 114 217 / 13%); }
        button { width:100%; padding:12px; border:0; border-radius:10px; color:#fff; background:var(--purple); box-shadow:0 8px 18px rgb(96 72 165 / 18%); font:inherit; font-weight:750; cursor:pointer; transition:.16s ease; }
        button:hover { transform:translateY(-1px); background:#503b91; }
        button:active { transform:scale(.98); }
        .error { color:#a24767; font-size:.8rem; }.link { margin:22px 0 0; text-align:center; font-size:.85rem; }.link a { color:var(--purple); font-weight:800; text-decoration:none; }
        @keyframes enter { from { opacity:0; transform:translateY(12px) scale(.985); } to { opacity:1; transform:none; } }
        @media (prefers-reduced-motion:reduce) { .card { animation:none; } }
    </style>
</head>
<body>
<main class="card">
    <a class="brand" href="{{ route('login') }}"><span class="brand-mark">T</span>My Tasks</a>
    <h1>Welcome back.</h1>
    <p>Log in to continue to your workspace.</p>
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="field"><label for="email">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>@error('email')<div class="error">{{ $message }}</div>@enderror</div>
        <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" required>@error('password')<div class="error">{{ $message }}</div>@enderror</div>
        <button type="submit">Log in</button>
    </form>
    <p class="link">New here? <a href="{{ route('register') }}">Create an account</a></p>
</main>
</body>
</html>
