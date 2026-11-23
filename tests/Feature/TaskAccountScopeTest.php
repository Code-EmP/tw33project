<?php

use App\Models\Task;
use App\Models\User;

test('members only see and create their own tasks', function () {
    $firstUser = User::factory()->create();
    $secondUser = User::factory()->create();
    Task::create(['user_id' => $secondUser->id, 'task_title' => 'Private task', 'description' => null]);

    $this->actingAs($firstUser)->post(route('tasks.store'), [
        'task_title' => 'My task', 'description' => 'Personal work',
    ])->assertRedirectToRoute('tasks.index');

    $response = $this->actingAs($firstUser)->get(route('tasks.index'));

    $response->assertOk()->assertSee('My task')->assertDontSee('Private task');
    expect(Task::where('task_title', 'My task')->value('user_id'))->toBe($firstUser->id);
});

test('admins can see tasks belonging to every account', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $member = User::factory()->create();
    Task::create(['user_id' => $member->id, 'task_title' => 'Member task', 'description' => null]);

    $this->actingAs($admin)->get(route('tasks.index'))
        ->assertOk()
        ->assertSee('Member task')
        ->assertSee($member->email);
});

test('admins can edit and delete member tasks while members cannot', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $member = User::factory()->create();
    $task = Task::create(['user_id' => $member->id, 'task_title' => 'Original task', 'description' => null]);

    $this->actingAs($member)->patch(route('tasks.update', $task), [
        'task_title' => 'Changed task', 'description' => null, 'completed' => 1,
    ])->assertForbidden();

    $this->actingAs($admin)->patch(route('tasks.update', $task), [
        'task_title' => 'Changed task', 'description' => 'Updated by admin', 'completed' => 1,
    ])->assertRedirectToRoute('tasks.index');

    expect($task->fresh()->task_title)->toBe('Changed task')
        ->and($task->fresh()->completed)->toBeTrue();

    $this->actingAs($admin)->delete(route('tasks.destroy', $task))
        ->assertRedirectToRoute('tasks.index');

    expect(Task::find($task->id))->toBeNull();
});
