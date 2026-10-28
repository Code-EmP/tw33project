<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | My Tasks</title>
    <style>
        :root {
            --ink: #302a3d;
            --muted: #817991;
            --line: #e9e3f3;
            --lavender: #f7f4ff;
            --purple: #6048a5;
            --purple-soft: #eee9ff;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: var(--ink); background: var(--lavender); }
        a { color: inherit; }

        .topbar {
            position: sticky;
            z-index: 5;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 72px;
            padding: 0 6vw;
            border-bottom: 1px solid var(--line);
            background: rgb(255 255 255 / 90%);
            backdrop-filter: blur(14px);
        }

        .brand { display: flex; align-items: center; gap: 10px; color: var(--ink); font-weight: 850; letter-spacing: -.04em; text-decoration: none; }
        .brand-mark { display: grid; width: 31px; height: 31px; place-items: center; color: #fff; border-radius: 10px; background: var(--purple); font-size: .82rem; }
        nav { display: flex; gap: 7px; }
        nav a { padding: 9px 13px; color: var(--muted); border-radius: 9px; font-size: .82rem; font-weight: 650; text-decoration: none; }
        nav a:hover, nav a.active { color: var(--purple); background: var(--lavender); }

        main { width: min(100% - 32px, 1000px); margin: 0 auto; padding: 72px 0 65px; }
        .intro { max-width: 700px; margin-bottom: 40px; }
        .eyebrow { margin: 0 0 11px; color: var(--purple); font-size: .7rem; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; }
        h1, h2, h3, p { margin-top: 0; }
        h1 { margin-bottom: 15px; font-size: clamp(2.3rem, 6vw, 4rem); line-height: .98; letter-spacing: -.075em; }
        .intro p:last-child { margin-bottom: 0; color: var(--muted); font-size: .95rem; line-height: 1.8; }

        .overview { display: grid; grid-template-columns: 1.3fr .7fr; gap: 18px; margin-bottom: 18px; }
        .card { border: 1px solid var(--line); border-radius: 21px; background: rgb(255 255 255 / 90%); box-shadow: 0 14px 35px rgb(99 77 165 / 7%); }
        .course-card { position: relative; min-height: 245px; overflow: hidden; padding: 28px; background: linear-gradient(135deg, #fff 0%, #f0ecff 100%); }
        .course-card::after { position: absolute; right: -54px; bottom: -90px; width: 230px; height: 230px; border: 34px solid rgb(169 152 228 / 20%); border-radius: 50%; content: ""; }
        .card-icon { position: relative; z-index: 1; display: grid; width: 44px; height: 44px; place-items: center; color: var(--purple); border-radius: 13px; background: var(--purple-soft); font-size: 1.15rem; }
        .course-card h2 { position: relative; z-index: 1; max-width: 450px; margin: 27px 0 10px; font-size: 1.7rem; letter-spacing: -.055em; }
        .course-card p { position: relative; z-index: 1; max-width: 450px; margin-bottom: 0; color: var(--muted); font-size: .84rem; line-height: 1.7; }
        .module-card { display: flex; flex-direction: column; justify-content: space-between; padding: 26px; }
        .label { margin-bottom: 12px; color: var(--muted); font-size: .7rem; font-weight: 750; letter-spacing: .08em; text-transform: uppercase; }
        .module-card h2 { margin-bottom: 0; color: var(--purple); font-size: 1.5rem; letter-spacing: -.05em; }
        .module-number { align-self: flex-end; color: #d7cff5; font-size: 4.5rem; font-weight: 850; line-height: .8; letter-spacing: -.1em; }

        .learning { padding: 25px 28px; }
        .learning-heading { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 22px; }
        h3 { margin-bottom: 0; font-size: 1.1rem; letter-spacing: -.035em; }
        .learning-heading span { color: var(--muted); font-size: .74rem; }
        .learning-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 13px; }
        .learning-item { padding: 17px; border: 1px solid var(--line); border-radius: 14px; background: #fcfbff; }
        .learning-item strong { display: block; margin-bottom: 7px; color: var(--purple); font-size: .84rem; }
        .learning-item p { margin-bottom: 0; color: var(--muted); font-size: .76rem; line-height: 1.55; }
        footer { display: flex; justify-content: space-between; margin-top: 36px; color: #aaa4b2; font-size: .7rem; font-weight: 600; }

        @media (max-width: 650px) {
            .topbar { padding: 0 16px; }
            .brand span:last-child { display: none; }
            nav a { padding: 8px 6px; font-size: .74rem; }
            main { padding-top: 46px; }
            .overview, .learning-grid { grid-template-columns: 1fr; }
            .module-card { min-height: 190px; }
        }
    </style>
</head>

<body>
    <header class="topbar">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">T</span><span>My Tasks</span></a>
        <nav aria-label="Main navigation">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('members.index') }}">Members</a>
            <a href="{{ route('tasks.index') }}">Tasks</a>
            <a class="active" href="{{ url('/about') }}">About</a>
        </nav>
    </header>

    <main>
        <section class="intro">
            <p class="eyebrow">A little context</p>
            <h1>Built for learning, focus, and steady progress.</h1>
            <p>This workspace brings simple task management and member organization together in one calm, easy-to-use experience.</p>
        </section>

        <section class="overview" aria-label="Course overview">
            <article class="card course-card">
                <div class="card-icon">✦</div>
                <h2>{{ $course }}</h2>
                <p>A practical space for exploring modern web systems, organizing work, and building useful Laravel foundations.</p>
            </article>
            <article class="card module-card">
                <div><p class="label">Current module</p><h2>{{ $module }}</h2></div>
                <span class="module-number">01</span>
            </article>
        </section>

        <section class="card learning" aria-labelledby="learning-heading">
            <div class="learning-heading"><h3 id="learning-heading">What this workspace supports</h3><span>Small steps add up</span></div>
            <div class="learning-grid">
                <article class="learning-item"><strong>Organize</strong><p>Keep tasks clear, current, and easy to revisit.</p></article>
                <article class="learning-item"><strong>Manage</strong><p>Maintain member profiles and important details.</p></article>
                <article class="learning-item"><strong>Build</strong><p>Turn Laravel concepts into working features.</p></article>
            </div>
        </section>

        <footer><span>TW33 · Web System Technologies</span><span>One step at a time.</span></footer>
    </main>
</body>

</html>
