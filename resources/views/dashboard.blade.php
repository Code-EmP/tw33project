<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | My Tasks</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #302a3d;
            --muted: #817991;
            --line: #e9e3f3;
            --lavender: #f7f4ff;
            --lavender-dark: #634da5;
            --lavender-mid: #a998e4;
            --white: #ffffff;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: var(--ink); background: var(--lavender); }
        a { color: inherit; }

        .top-navigation {
            position: fixed;
            z-index: 10;
            top: 0;
            right: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 72px;
            padding: 0 6vw;
            border-bottom: 1px solid rgb(233 227 243 / 85%);
            background: rgb(255 255 255 / 88%);
            backdrop-filter: blur(14px);
        }

        .brand { display: flex; align-items: center; gap: 10px; color: var(--ink); font-size: 1.05rem; font-weight: 850; letter-spacing: -.04em; text-decoration: none; }
        .brand-icon { display: grid; width: 31px; height: 31px; place-items: center; color: #fff; border-radius: 10px; background: var(--lavender-dark); font-size: .82rem; }
        .main-nav { display: flex; align-items: center; gap: 8px; }
        .main-nav a { padding: 9px 13px; color: var(--muted); border-radius: 9px; font-size: .82rem; font-weight: 650; text-decoration: none; }
        .main-nav a:hover, .main-nav a.active { color: var(--lavender-dark); background: var(--lavender); }
        .profile { display: grid; width: 32px; height: 32px; place-items: center; color: var(--lavender-dark); border: 1px solid var(--line); border-radius: 50%; background: #fff; font-size: .65rem; font-weight: 800; }

        main { width: min(100% - 40px, 1100px); margin: 0 auto; padding: 124px 0 56px; }
        .intro { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; margin-bottom: 30px; }
        .eyebrow { margin: 0 0 10px; color: var(--lavender-dark); font-size: .7rem; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; }
        h1, h2, h3, p { margin-top: 0; }
        h1 { max-width: 620px; margin-bottom: 10px; font-size: clamp(2.1rem, 5vw, 3.6rem); line-height: .98; letter-spacing: -.07em; }
        .intro-copy { margin-bottom: 0; color: var(--muted); font-size: .9rem; }
        .date-chip { padding: 9px 13px; color: var(--lavender-dark); border: 1px solid var(--line); border-radius: 999px; background: #fff; font-size: .76rem; font-weight: 700; white-space: nowrap; }

        .hero {
            display: grid;
            grid-template-columns: 1.35fr .65fr;
            gap: 18px;
            margin-bottom: 18px;
        }

        .hero-card, .progress-card, .recent-card { border: 1px solid var(--line); border-radius: 22px; background: rgb(255 255 255 / 88%); box-shadow: 0 14px 35px rgb(99 77 165 / 7%); }
        .hero-card { position: relative; min-height: 250px; overflow: hidden; padding: 29px; background: linear-gradient(135deg, #fff 0%, #f1edff 100%); }
        .hero-card::after { position: absolute; right: -65px; bottom: -90px; width: 240px; height: 240px; border: 35px solid rgb(169 152 228 / 18%); border-radius: 50%; content: ""; }
        .hero-card h2 { position: relative; z-index: 1; max-width: 440px; margin: 25px 0 12px; font-size: 2rem; line-height: 1.05; letter-spacing: -.055em; }
        .hero-card p { position: relative; z-index: 1; max-width: 420px; margin-bottom: 25px; color: var(--muted); font-size: .86rem; line-height: 1.7; }
        .hero-kicker { position: relative; z-index: 1; display: inline-flex; align-items: center; gap: 8px; color: var(--lavender-dark); font-size: .75rem; font-weight: 800; }
        .hero-kicker::before { width: 7px; height: 7px; border-radius: 50%; background: var(--lavender-mid); content: ""; }
        .primary-button { position: relative; z-index: 1; display: inline-flex; align-items: center; gap: 25px; padding: 12px 15px; color: #fff; border-radius: 10px; background: var(--lavender-dark); box-shadow: 0 7px 14px rgb(99 77 165 / 22%); font-size: .79rem; font-weight: 750; text-decoration: none; }
        .primary-button:hover { background: #503b91; }

        .progress-card { display: flex; min-height: 250px; flex-direction: column; justify-content: space-between; padding: 25px; }
        .card-label { margin-bottom: 15px; color: var(--muted); font-size: .73rem; font-weight: 750; }
        .progress-number { margin: 0; color: var(--lavender-dark); font-size: 3.5rem; font-weight: 850; letter-spacing: -.08em; }
        .progress-caption { margin: 0; color: var(--muted); font-size: .78rem; }
        .progress-track { height: 9px; overflow: hidden; border-radius: 99px; background: var(--lavender); }
        .progress-fill { width: {{ $completionRate }}%; height: 100%; border-radius: inherit; background: linear-gradient(90deg, var(--lavender-mid), var(--lavender-dark)); }

        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 18px; }
        .stat-card { padding: 21px 23px; border: 1px solid var(--line); border-radius: 18px; background: #fff; }
        .stat-card p { margin-bottom: 9px; color: var(--muted); font-size: .76rem; font-weight: 700; }
        .stat-card strong { color: var(--ink); font-size: 1.8rem; letter-spacing: -.05em; }

        .section-heading { display: flex; align-items: center; justify-content: space-between; margin: 31px 0 13px; }
        h2 { margin-bottom: 0; font-size: 1.15rem; letter-spacing: -.035em; }
        .section-heading a { color: var(--lavender-dark); font-size: .78rem; font-weight: 750; text-decoration: none; }
        .recent-card { overflow: hidden; }
        .task-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 17px 22px; border-bottom: 1px solid var(--line); }
        .task-row:last-child { border-bottom: 0; }
        .task-name { margin-bottom: 5px; font-size: .88rem; font-weight: 750; }
        .task-date { margin-bottom: 0; color: var(--muted); font-size: .75rem; }
        .status { padding: 6px 10px; color: var(--lavender-dark); border-radius: 99px; background: var(--lavender); font-size: .7rem; font-weight: 750; white-space: nowrap; }
        .empty { margin: 0; padding: 25px; color: var(--muted); font-size: .84rem; text-align: center; }

        @media (max-width: 700px) {
            .top-navigation { padding: 0 20px; }
            .main-nav a { padding: 8px; font-size: .75rem; }
            .profile { display: none; }
            main { width: min(100% - 28px, 560px); padding-top: 108px; }
            .intro { align-items: flex-start; flex-direction: column; }
            .date-chip { margin-top: -8px; }
            .hero { grid-template-columns: 1fr; }
            .stats { gap: 10px; }
            .stat-card { padding: 16px; }
        }

        @media (max-width: 430px) {
            .brand span:last-child { display: none; }
            .main-nav { margin-left: auto; }
            .main-nav a { padding: 7px 6px; }
            .stats { grid-template-columns: 1fr; }
            .hero-card, .progress-card { padding: 23px; }
            .task-row { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>

<body>
    <header class="top-navigation">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-icon">T</span><span>My Tasks</span></a>
        <nav class="main-nav" aria-label="Main navigation">
            <a class="active" href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('members.index') }}">Members</a>
            <a href="{{ route('tasks.index') }}">Tasks</a>
            <a href="{{ url('/about') }}">About</a>
        </nav>
        <span class="profile">TW</span>
    </header>

    <main>
        <section class="intro" aria-labelledby="dashboard-title">
            <div>
                <p class="eyebrow">Your little corner of progress</p>
                <h1 id="dashboard-title">Make space for what matters.</h1>
                <p class="intro-copy">A simple overview of your tasks, all in one calm place.</p>
            </div>
            <span class="date-chip">TW33 Workspace</span>
        </section>

        <section class="hero" aria-label="Workspace overview">
            <article class="hero-card">
                <span class="hero-kicker">Today’s focus</span>
                <h2>One clear step is still progress.</h2>
                <p>Capture your next idea, keep your list tidy, and move through your day at your own pace.</p>
                <a class="primary-button" href="{{ route('tasks.index') }}">Open task list <span>→</span></a>
            </article>
            <article class="progress-card">
                <div><p class="card-label">Overall completion</p><p class="progress-number">{{ $completionRate }}%</p><p class="progress-caption">of your tasks are complete</p></div>
                <div class="progress-track" aria-label="{{ $completionRate }} percent complete"><div class="progress-fill"></div></div>
            </article>
        </section>

        <section class="stats" aria-label="Task summary">
            <article class="stat-card"><p>Total tasks</p><strong>{{ $totalTasks }}</strong></article>
            <article class="stat-card"><p>Completed</p><strong>{{ $completedTasks }}</strong></article>
            <article class="stat-card"><p>Still to do</p><strong>{{ $pendingTasks }}</strong></article>
        </section>

        <section aria-labelledby="recent-heading">
            <div class="section-heading"><h2 id="recent-heading">Recently added</h2><a href="{{ route('tasks.index') }}">See all tasks →</a></div>
            <div class="recent-card">
                @forelse ($recentTasks as $task)
                <article class="task-row">
                    <div><p class="task-name">{{ $task->task_title }}</p><p class="task-date">Added {{ $task->created_at->format('M j, Y') }}</p></div>
                    <span class="status">{{ $task->completed ? 'Completed' : 'Not completed' }}</span>
                </article>
                @empty
                <p class="empty">Your task list is waiting for its first item.</p>
                @endforelse
            </div>
        </section>
    </main>
</body>

</html>
