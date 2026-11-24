<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = Task::query()
            ->with('user')
            ->when(! $request->user()->isAdmin(), fn ($query) => $query->where('user_id', $request->user()->id))
            ->latest()
            ->get();

        return view('tasks', [
            'tasks' => $tasks,
            'isAdminView' => $request->user()->isAdmin(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $dateRules = ['nullable', 'date'];
        $dueDateRules = ['nullable', 'date'];

        if ($request->filled('start_date')) {
            $dueDateRules[] = 'after_or_equal:start_date';
        }

        $validated = $request->validate([
            'task_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => $dateRules,
            'due_date' => $dueDateRules,
        ]);

        $request->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task added successfully.');
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $this->authorizeTask($request, $task);

        $dueDateRules = ['nullable', 'date'];

        if ($request->filled('start_date')) {
            $dueDateRules[] = 'after_or_equal:start_date';
        }

        $validated = $request->validate([
            'task_title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'due_date' => $dueDateRules,
            'completed' => ['required', 'boolean'],
        ]);

        $task->update($validated);

        return to_route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
        $this->authorizeTask($request, $task);
        $task->delete();

        return to_route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    private function authorizeTask(Request $request, Task $task): void
    {
        abort_unless(
            $request->user()->isAdmin() || (int) $task->user_id === (int) $request->user()->id,
            404,
        );
    }
}
