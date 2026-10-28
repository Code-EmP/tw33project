<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Members') | My Tasks</title>
    <style>
        :root { --ink: #302a3d; --muted: #817991; --line: #e9e3f3; --lavender: #f7f4ff; --purple: #6048a5; --white: #fff; font-family: Inter, ui-sans-serif, system-ui, sans-serif; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: var(--ink); background: var(--lavender); }
        a { color: inherit; }
        .topbar { position: sticky; z-index: 5; top: 0; display: flex; align-items: center; justify-content: space-between; min-height: 72px; padding: 0 6vw; border-bottom: 1px solid var(--line); background: rgb(255 255 255 / 90%); backdrop-filter: blur(14px); }
        .brand { display: flex; align-items: center; gap: 10px; color: var(--ink); font-weight: 850; letter-spacing: -.04em; text-decoration: none; }
        .brand-mark { display: grid; width: 31px; height: 31px; place-items: center; color: #fff; border-radius: 10px; background: var(--purple); font-size: .82rem; }
        nav { display: flex; gap: 7px; }
        nav a { padding: 9px 13px; color: var(--muted); border-radius: 9px; font-size: .82rem; font-weight: 650; text-decoration: none; }
        nav a:hover, nav a.active { color: var(--purple); background: var(--lavender); }
        main { width: min(100% - 32px, 1040px); margin: 0 auto; padding: 48px 0 60px; }
        .heading, .toolbar, .member-heading, .actions { display: flex; align-items: center; justify-content: space-between; gap: 18px; }
        .eyebrow { margin: 0 0 9px; color: var(--purple); font-size: .68rem; font-weight: 800; letter-spacing: .15em; text-transform: uppercase; }
        h1, h2, h3, p { margin-top: 0; }
        h1 { margin-bottom: 8px; font-size: clamp(2rem, 5vw, 3rem); letter-spacing: -.06em; }
        h2 { margin-bottom: 5px; font-size: 1.2rem; letter-spacing: -.035em; }
        .muted { color: var(--muted); font-size: .86rem; }
        .button { display: inline-flex; align-items: center; justify-content: center; padding: 11px 16px; color: #fff; border: 0; border-radius: 10px; background: var(--purple); font: inherit; font-size: .82rem; font-weight: 750; text-decoration: none; cursor: pointer; }
        .button:hover { background: #503b91; }
        .button.secondary { color: var(--purple); background: #eee9ff; }
        .button.danger { color: #a24767; background: #fff0f5; }
        .toolbar { margin: 30px 0 17px; }
        .search { display: flex; flex: 1; max-width: 470px; gap: 8px; }
        .search input, input, select { width: 100%; padding: 11px 13px; color: var(--ink); border: 1px solid #ddd6eb; border-radius: 10px; outline: 0; background: var(--white); font: inherit; font-size: .84rem; }
        input:focus, select:focus { border-color: #9a84df; box-shadow: 0 0 0 4px rgb(139 114 217 / 13%); }
        .member-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
        .member-card, .form-card, .profile-card { border: 1px solid var(--line); border-radius: 18px; background: rgb(255 255 255 / 90%); box-shadow: 0 12px 30px rgb(96 72 165 / 6%); }
        .member-card { padding: 20px; }
        .avatar { display: grid; width: 42px; height: 42px; place-items: center; margin-bottom: 17px; color: var(--purple); border-radius: 13px; background: #eee9ff; font-weight: 800; }
        .member-card h3 { margin-bottom: 5px; font-size: 1rem; }
        .member-email { margin-bottom: 17px; overflow: hidden; color: var(--muted); font-size: .76rem; text-overflow: ellipsis; white-space: nowrap; }
        .tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 18px; }
        .tag, .status { padding: 5px 8px; color: var(--purple); border-radius: 999px; background: var(--lavender); font-size: .69rem; font-weight: 750; }
        .status.inactive { color: #a24767; background: #fff0f5; }
        .empty, .alert { padding: 20px; border-radius: 13px; background: #fff; color: var(--muted); text-align: center; }
        .alert { margin: 22px 0 0; color: var(--purple); background: #eee9ff; text-align: left; }
        .form-card, .profile-card { max-width: 680px; margin: 32px auto 0; padding: 26px; }
        .field { margin-bottom: 17px; }
        label { display: block; margin-bottom: 7px; color: #554c66; font-size: .8rem; font-weight: 700; }
        .field-error { margin: 6px 0 0; color: #a24767; font-size: .76rem; }
        .form-actions { display: flex; gap: 10px; margin-top: 25px; }
        .profile-heading { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .profile-heading .avatar { margin: 0; }
        .details { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; padding: 22px 0; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
        .detail-label { margin-bottom: 5px; color: var(--muted); font-size: .72rem; font-weight: 700; }
        .detail-value { margin: 0; font-size: .9rem; font-weight: 650; }
        .actions { justify-content: flex-start; margin-top: 22px; }
        form.inline { display: inline; }
        .pagination { display: flex; gap: 7px; margin-top: 20px; }
        .pagination a, .pagination span { padding: 7px 10px; color: var(--purple); border: 1px solid var(--line); border-radius: 8px; background: #fff; font-size: .75rem; text-decoration: none; }
        @media (max-width: 750px) { .member-grid { grid-template-columns: repeat(2, 1fr); } .heading { align-items: flex-start; flex-direction: column; } }
        @media (max-width: 500px) { .topbar { padding: 0 16px; } .brand span:last-child { display: none; } nav a { padding: 8px 6px; font-size: .74rem; } main { padding-top: 32px; } .toolbar { align-items: stretch; flex-direction: column; } .search { max-width: none; } .member-grid, .details { grid-template-columns: 1fr; } .form-card, .profile-card { padding: 20px; } }
    </style>
</head>

<body>
    <header class="topbar">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">T</span><span>My Tasks</span></a>
        <nav aria-label="Main navigation">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a class="active" href="{{ route('members.index') }}">Members</a>
            <a href="{{ route('tasks.index') }}">Tasks</a>
        </nav>
    </header>
    <main>@yield('content')</main>
</body>

</html>
