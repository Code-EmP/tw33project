<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | My Tasks</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <style>
        :root { color-scheme:light; --ink:#302a3d; --muted:#817991; --line:#e9e3f3; --purple:#6048a5; --lavender:#f7f4ff; }
        * { box-sizing:border-box; } body { min-height:100vh; margin:0; display:grid; place-items:center; overflow-x:hidden; color:var(--ink); background:radial-gradient(circle at 10% 10%,#eee8ff 0,transparent 28%),radial-gradient(circle at 90% 90%,#e9e2ff 0,transparent 30%),var(--lavender); font:15px Inter,ui-sans-serif,system-ui,sans-serif; }
        .card { width:min(calc(100% - 32px),460px); margin:28px 0; padding:34px 38px; border:1px solid var(--line); border-radius:24px; background:rgb(255 255 255 / 94%); box-shadow:0 24px 60px rgb(96 72 165 / 14%); animation:enter .45s ease-out both; }
        .brand { display:inline-flex; align-items:center; gap:9px; color:var(--purple); font-weight:850; text-decoration:none; }.brand-mark { display:grid; width:32px; height:32px; place-items:center; border-radius:10px; color:#fff; background:var(--purple); }
        h1 { margin:24px 0 7px; font-size:2.05rem; letter-spacing:-.06em; } p { color:var(--muted); line-height:1.55; }.field { margin:14px 0; }label { display:block; margin-bottom:7px; font-size:.82rem; font-weight:750; }
        input { width:100%; padding:11px 13px; border:1px solid #ddd6eb; border-radius:10px; outline:0; background:#fff; font:inherit; transition:.16s ease; }input:focus { border-color:#9a84df; box-shadow:0 0 0 4px rgb(139 114 217 / 13%); }
        button { width:100%; padding:12px; border:0; border-radius:10px; color:#fff; background:var(--purple); box-shadow:0 8px 18px rgb(96 72 165 / 18%); font:inherit; font-weight:750; cursor:pointer; transition:.16s ease; }button:hover { transform:translateY(-1px); background:#503b91; }button:active { transform:scale(.98); }
        .error { color:#a24767; font-size:.8rem; }.link { margin:18px 0 0; text-align:center; font-size:.85rem; }.link a { color:var(--purple); font-weight:800; text-decoration:none; }@keyframes enter { from { opacity:0; transform:translateY(12px) } to { opacity:1; transform:none } }@media (prefers-reduced-motion:reduce) { .card { animation:none; } }
    </style>
</head>
<body>
<main class="card">
    <a class="brand" href="{{ route('login') }}"><span class="brand-mark">T</span>My Tasks</a>
    <h1>Create your account.</h1>
    <p>Register as a member and get Basic membership free.</p>
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="field"><label for="name">Full name</label><input id="name" name="name" value="{{ old('name') }}" required>@error('name')<div class="error">{{ $message }}</div>@enderror</div>
        <div class="field"><label for="email">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" required>@error('email')<div class="error">{{ $message }}</div>@enderror</div>
        <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" required>@error('password')<div class="error">{{ $message }}</div>@enderror</div>
        <div class="field"><label for="password_confirmation">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" required></div>
        <button type="submit">Create account</button>
    </form>
    <p class="link">Already registered? <a href="{{ route('login') }}">Log in</a></p>
</main>
</body>
</html>
