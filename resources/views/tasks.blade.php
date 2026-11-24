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
            position: relative;
            overflow: hidden;
        }

        .panel::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--lavender-500), var(--lavender-200));
            content: "";
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
        textarea,
        select {
            width: 100%;
            margin-bottom: 18px;
            padding: 12px 14px;
            color: var(--ink);
            border: 1px solid #dcd6e8;
            border-radius: 10px;
            outline: none;
            background: var(--white);
            font: inherit;
            transition: border-color 160ms ease, box-shadow 160ms ease, background 160ms ease;
        }

        select {
            appearance: none;
            padding-right: 40px;
            background-image: linear-gradient(45deg, transparent 50%, var(--lavender-700) 50%), linear-gradient(135deg, var(--lavender-700) 50%, transparent 50%);
            background-position: calc(100% - 18px) 50%, calc(100% - 13px) 50%;
            background-repeat: no-repeat;
            background-size: 5px 5px, 5px 5px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--lavender-500);
            box-shadow: 0 0 0 4px rgb(139 114 217 / 14%);
        }

        input::placeholder,
        textarea::placeholder {
            color: #a49caf;
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

        button:focus-visible,
        .task-list summary:focus-visible {
            outline: 3px solid rgb(139 114 217 / 35%);
            outline-offset: 3px;
        }

        .task-list {
            display: grid;
            gap: 12px;
        }

        article {
            position: relative;
            padding: 20px 22px;
        }

        article::after {
            position: absolute;
            top: 19px;
            left: 0;
            width: 3px;
            height: 34px;
            border-radius: 0 4px 4px 0;
            background: var(--lavender-200);
            content: "";
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

        article > p:not(.status) {
            max-width: 62ch;
        }

        .task-list details {
            margin-top: 18px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .task-list summary {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--lavender-700);
            cursor: pointer;
            font-size: 0.86rem;
            font-weight: 750;
            list-style: none;
        }

        .task-list summary::-webkit-details-marker {
            display: none;
        }

        .task-list summary::before {
            display: grid;
            width: 22px;
            height: 22px;
            place-items: center;
            border: 1px solid var(--lavender-200);
            border-radius: 7px;
            background: var(--lavender-100);
            content: "+";
            font-size: 1rem;
            line-height: 1;
        }

        .task-list details[open] summary::before {
            content: "−";
        }

        .task-list details form {
            margin-top: 18px;
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 13px;
            background: rgb(250 248 255 / 70%);
        }

        .task-list details form + form {
            margin-top: 10px;
            padding: 0;
            border: 0;
            background: transparent;
        }

        .task-list details button {
            margin-right: 8px;
        }

        .task-list details form + form button {
            color: #a14363;
            border: 1px solid #f0cad6;
            background: #fff5f7;
            box-shadow: none;
        }

        .task-list details form + form button:hover {
            background: #ffe8ef;
        }

        .date-fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 16px;
        }

        .task-dates {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 18px;
            color: var(--muted);
            font-size: 0.88rem;
        }

        .task-dates p {
            margin-bottom: 8px;
        }

        .task-list details summary {
            min-height: 40px;
            padding: 8px 13px;
            border: 1px solid var(--lavender-200);
            border-radius: 9px;
            background: var(--lavender-100);
        }

        .task-list details[open] summary {
            margin-bottom: 2px;
        }

        @media (max-width: 480px) {
            .date-fields {
                grid-template-columns: 1fr;
                gap: 0;
            }
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

            article {
                padding: 18px;
            }

            .task-list details form {
                padding: 15px;
            }

            .task-list details button {
                width: 100%;
                margin: 0 0 9px;
            }

            .task-list details form + form button {
                margin-bottom: 0;
            }
        }
    </style>
</head>

<body class="task-page">
    @include('partials.navigation')
    <main>
        <header class="page-header">
            <p class="eyebrow">A little progress every day</p>
            <h1>{{ $isAdminView ? "All Members' Tasks" : 'My Tasks' }}</h1>
        </header>

        @if (! $isAdminView)
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
                <div class="date-fields">
                    <div>
                        <label for="start_date">Date from <span>(optional)</span></label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="due_date">Date until / deadline <span>(optional)</span></label>
                        <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}">
                        @error('due_date')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit">Add Task</button>
            </form>
        </section>
        @endif

        <section aria-labelledby="saved-tasks-heading">
            <h2 id="saved-tasks-heading">Saved Tasks</h2>
            <div class="task-list">
                @forelse ($tasks as $task)
                <article>
                    <h3>{{ $task->task_title }}</h3>
                    @if ($isAdminView)
                    <p class="status">Owner: {{ $task->user?->name ?? 'Legacy task without an account' }}{{ $task->user?->email ? ' ('.$task->user->email.')' : '' }}</p>
                    @endif
                    <p>{{ $task->description ?: 'No description provided.' }}</p>
                    @if ($task->start_date || $task->due_date)
                    <div class="task-dates">
                        @if ($task->start_date)
                        <p><strong>From:</strong> {{ $task->start_date->format('M j, Y') }}</p>
                        @endif
                        @if ($task->due_date)
                        <p><strong>Until:</strong> {{ $task->due_date->format('M j, Y') }}</p>
                        @endif
                    </div>
                    @endif
                    <p class="status">{{ $task->completed ? 'Completed' : 'Not completed' }}</p>
                    <details>
                        <summary>Edit task</summary>
                        <form action="{{ route('tasks.update', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label for="task_title_{{ $task->id }}">Task title</label>
                            <input type="text" id="task_title_{{ $task->id }}" name="task_title" value="{{ $task->task_title }}" required>
                            <label for="description_{{ $task->id }}">Description</label>
                            <textarea id="description_{{ $task->id }}" name="description">{{ $task->description }}</textarea>
                            <div class="date-fields">
                                <div>
                                    <label for="start_date_{{ $task->id }}">Date from</label>
                                    <input type="date" id="start_date_{{ $task->id }}" name="start_date" value="{{ $task->start_date?->format('Y-m-d') }}">
                                </div>
                                <div>
                                    <label for="due_date_{{ $task->id }}">Date until / deadline</label>
                                    <input type="date" id="due_date_{{ $task->id }}" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}">
                                </div>
                            </div>
                            <label for="completed_{{ $task->id }}">Status</label>
                            <select id="completed_{{ $task->id }}" name="completed">
                                <option value="0" @selected(! $task->completed)>Not completed</option>
                                <option value="1" @selected($task->completed)>Completed</option>
                            </select>
                            <button type="submit">Save changes</button>
                        </form>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete task</button>
                        </form>
                    </details>
                </article>
                @empty
                <p class="empty">No tasks have been added yet.</p>
                @endforelse
            </div>
        </section>
    </main>
</body>

</html>
