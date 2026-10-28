@extends('members.layout')

@section('title', 'Membership Setup')

@section('content')
<style>
    .settings-grid { display: grid; grid-template-columns: .8fr 1.2fr; gap: 18px; }
    .setup-card { padding: 24px; border: 1px solid var(--line); border-radius: 18px; background: rgb(255 255 255 / 90%); box-shadow: 0 12px 30px rgb(96 72 165 / 6%); }
    .setup-card h2 { margin-bottom: 6px; }
    .setup-card > p { margin-bottom: 22px; color: var(--muted); font-size: .8rem; line-height: 1.6; }
    .setup-list { display: grid; gap: 10px; margin-top: 22px; }
    .setup-item { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 13px; border: 1px solid var(--line); border-radius: 12px; background: #fcfbff; }
    .setup-item strong { display: block; margin-bottom: 3px; font-size: .84rem; }
    .setup-item small { color: var(--muted); font-size: .72rem; }
    .edit-form { display: grid; gap: 8px; width: 100%; }
    .edit-form .field { margin-bottom: 5px; }
    textarea { width: 100%; min-height: 72px; padding: 11px 13px; color: var(--ink); border: 1px solid #ddd6eb; border-radius: 10px; outline: 0; background: #fff; font: inherit; font-size: .84rem; resize: vertical; }
    textarea:focus { border-color: #9a84df; box-shadow: 0 0 0 4px rgb(139 114 217 / 13%); }
    .setup-item form { margin: 0; }
    .mini-button { padding: 8px 10px; color: var(--purple); border: 0; border-radius: 8px; background: #eee9ff; cursor: pointer; font: inherit; font-size: .72rem; font-weight: 750; }
    .mini-button:hover { background: #e2d9ff; }
    @media (max-width: 780px) { .settings-grid { grid-template-columns: 1fr; } }
</style>

<section class="heading">
    <div><p class="eyebrow">Member management</p><h1>Membership setup</h1><p class="muted">Manage the categories and levels available when adding members.</p></div>
    <a class="button secondary" href="{{ route('members.index') }}">Back to members</a>
</section>

@if (session('success'))<p class="alert">{{ session('success') }}</p>@endif

<div class="settings-grid" style="margin-top: 30px;">
    <section class="setup-card">
        <h2>Categories</h2>
        <p>Use categories to describe the type of membership.</p>
        <form method="POST" action="{{ route('membership-settings.categories.store') }}">
            @csrf
            <div class="field"><label for="category_name">New category</label><input id="category_name" name="name" placeholder="e.g. Student" required>@error('name')<p class="field-error">{{ $message }}</p>@enderror</div>
            <div class="field"><label for="category_description">Description <span class="muted">(optional)</span></label><textarea id="category_description" name="description" placeholder="Short description"></textarea></div>
            <button class="button" type="submit">Add category</button>
        </form>
        <div class="setup-list">
            @foreach ($categories as $category)
            <details class="setup-item"><summary><strong>{{ $category->name }}</strong><small>{{ $category->is_active ? 'Available for members' : 'Inactive' }}</small></summary>
                <form class="edit-form" method="POST" action="{{ route('membership-settings.categories.update', $category) }}">
                    @csrf @method('PUT')
                    <div class="field"><label>Name</label><input name="name" value="{{ $category->name }}" required></div>
                    <div class="field"><label>Description</label><textarea name="description">{{ $category->description }}</textarea></div>
                    <label><input type="checkbox" name="is_active" value="1" @checked($category->is_active)> Active</label>
                    <button class="mini-button" type="submit">Save category</button>
                </form>
            </details>
            @endforeach
        </div>
    </section>

    <section class="setup-card">
        <h2>Membership levels</h2>
        <p>Set pricing, validity, and benefits for each membership level.</p>
        <form method="POST" action="{{ route('membership-settings.levels.store') }}">
            @csrf
            <div class="field"><label for="level_name">Level name</label><input id="level_name" name="name" placeholder="e.g. Gold" required></div>
            <div class="details" style="padding: 0; border: 0; grid-template-columns: 1fr 1fr;"><div class="field"><label for="fee">Fee</label><input id="fee" type="number" name="fee" min="0" step="0.01" placeholder="0.00" required></div><div class="field"><label for="validity_period">Validity period</label><input id="validity_period" name="validity_period" placeholder="e.g. 1 year" required></div></div>
            <div class="field"><label for="benefits">Benefits</label><textarea id="benefits" name="benefits" placeholder="List the benefits included"></textarea></div>
            <button class="button" type="submit">Add level</button>
        </form>
        <div class="setup-list">
            @foreach ($levels as $level)
            <details class="setup-item"><summary><strong>{{ $level->name }} · ₱{{ number_format((float) $level->fee, 2) }}</strong><small>{{ $level->validity_period }} · {{ $level->is_active ? 'Available' : 'Inactive' }}</small></summary>
                <form class="edit-form" method="POST" action="{{ route('membership-settings.levels.update', $level) }}">
                    @csrf @method('PUT')
                    <div class="field"><label>Name</label><input name="name" value="{{ $level->name }}" required></div>
                    <div class="details" style="padding: 0; border: 0; grid-template-columns: 1fr 1fr;"><div class="field"><label>Fee</label><input type="number" name="fee" value="{{ $level->fee }}" min="0" step="0.01" required></div><div class="field"><label>Validity</label><input name="validity_period" value="{{ $level->validity_period }}" required></div></div>
                    <div class="field"><label>Benefits</label><textarea name="benefits">{{ $level->benefits }}</textarea></div>
                    <label><input type="checkbox" name="is_active" value="1" @checked($level->is_active)> Active</label>
                    <button class="mini-button" type="submit">Save level</button>
                </form>
            </details>
            @endforeach
        </div>
    </section>
</div>
@endsection
