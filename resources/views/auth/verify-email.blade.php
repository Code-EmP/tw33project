<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email | My Tasks</title>
    <style>
        body { min-height: 100vh; display: grid; place-items: center; margin: 0; color: #302a3d; background: #f7f4ff; font: 15px system-ui, sans-serif; }
        .card { width: min(calc(100% - 32px), 470px); padding: 34px; border: 1px solid #e9e3f3; border-radius: 22px; background: #fff; box-shadow: 0 20px 50px rgb(96 72 165 / 12%); }
        h1 { margin-top: 0; }.muted { color: #817991; line-height: 1.6; }.button { width: 100%; padding: 12px; border: 0; border-radius: 10px; color: #fff; background: #6048a5; font: inherit; font-weight: 700; cursor: pointer; }.status { color: #6048a5; }.logout { margin-top: 14px; text-align: center; }.logout button { border: 0; color: #6048a5; background: none; font: inherit; cursor: pointer; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Verify your email address</h1>
        <p class="muted">Your account needs email verification before you can use the workspace. A verification link should arrive at <strong>{{ auth()->user()->email }}</strong>. Check your spam folder too.</p>
        @if (session('status'))<p class="status">{{ session('status') }}</p>@endif
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="button" type="submit">Resend verification email</button>
        </form>
        <form class="logout" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Log out</button>
        </form>
    </main>
</body>
</html>
