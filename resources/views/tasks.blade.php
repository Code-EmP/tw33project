<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <style>
        :root {
            color-scheme: light;
            --lavender-50: #faf8ff;
            --lavender-100: #f1edff;
            --lavender-200: #e4dcff;
            --lavender-500: #8b72d9;
            --lavender-700: #6048a5;
            --ink: #2f2940;
            --muted: #746d85;
            --border: #e8e3f0;
            --white: #ffffff;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 48px 20px;
            color: var(--ink);
            background: linear-gradient(135deg, #fdfcff 0%, var(--lavender-50) 55%, #f3efff 100%);
        }

        main {
            width: min(100%, 720px);
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 28px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--lavender-700);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        h1,
        h2,
        h3,
        p {
            margin-top: 0;
        }

        h1 {
            margin-bottom: 0;
            font-size: clamp(2rem, 5vw, 2.8rem);
            letter-spacing: -0.04em;
        }

        h2 {
            margin: 42px 0 16px;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
        }

        .panel h2 {
            margin-top: 0;
        }

        .panel,
        article {
            border: 1px solid var(--border);
            border-radius: 18px;
            background: rgb(255 255 255 / 82%);
            box-shadow: 0 12px 30px rgb(89 67 144 / 7%);
        }

        .panel {
            padding: 24px;
        }

        .success,
        .error {
            margin: 0 0 18px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 0.92rem;
        }

        .success {
            color: #4d3b83;
            border: 1px solid var(--lavender-200);
            background: var(--lavender-100);
        }

        .error {
            color: #a14363;
            background: #fff1f5;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #504960;
            font-size: 0.88rem;
            font-weight: 600;
        }

        input,
        textarea {
            width: 100%;
            margin-bottom: 18px;
            padding: 12px 14px;
            color: var(--ink);
            border: 1px solid #dcd6e8;
            border-radius: 10px;
            outline: none;
            background: var(--white);
            font: inherit;
            transition: border-color 160ms ease, box-shadow 160ms ease;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            border-color: var(--lavender-500);
            box-shadow: 0 0 0 4px rgb(139 114 217 / 14%);
        }

        button {
            padding: 11px 18px;
            color: var(--white);
            border: 0;
            border-radius: 10px;
            background: var(--lavender-700);
            box-shadow: 0 6px 14px rgb(96 72 165 / 20%);
            cursor: pointer;
            font: inherit;
            font-weight: 700;
            transition: background 160ms ease, transform 160ms ease;
        }

        button:hover {
            background: #503b91;
            transform: translateY(-1px);
        }

        .task-list {
            display: grid;
            gap: 12px;
        }

        article {
            padding: 20px 22px;
        }

        article h3 {
            margin-bottom: 8px;
            font-size: 1.05rem;
        }

        article p {
            margin-bottom: 12px;
            color: var(--muted);
            line-height: 1.6;
        }

        article .status {
            margin-bottom: 0;
            color: var(--lavender-700);
            font-size: 0.86rem;
            font-weight: 700;
        }

        .empty {
            padding: 22px;
            color: var(--muted);
            border: 1px dashed var(--lavender-200);
            border-radius: 14px;
            text-align: center;
        }

        @media (max-width: 480px) {
            body {
                padding: 30px 14px;
            }

            .panel {
                padding: 18px;
            }
        }
    </style>
</head>

<body>
    <main>
        <header class="page-header">
            <p class="eyebrow">A little progress every day</p>
            <h1>My Tasks</h1>
        </header>

        <section class="panel" aria-labelledby="add-task-heading">
            <h2 id="add-task-heading">Add a new task</h2>
            @if (session('success'))
            <p class="success">{{ session('success') }}</p>
            @endif
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <label for="task_title">Task title</label>
                <input type="text" id="task_title" name="task_title" value="{{ old('task_title') }}" required>
                @error('task_title')
                <p class="error">{{ $message }}</p>
                @enderror

                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="What needs to be done?">{{ old('description') }}</textarea>
                <button type="submit">Add Task</button>
            </form>
        </section>

        <section aria-labelledby="saved-tasks-heading">
            <h2 id="saved-tasks-heading">Saved Tasks</h2>
            <div class="task-list">
                @forelse ($tasks as $task)
                <article>
                    <h3>{{ $task->task_title }}</h3>
                    <p>{{ $task->description ?: 'No description provided.' }}</p>
                    <p class="status">{{ $task->completed ? 'Completed' : 'Not completed' }}</p>
                </article>
                @empty
                <p class="empty">No tasks have been added yet.</p>
                @endforelse
            </div>
        </section>
    </main>
</body>

</html>
