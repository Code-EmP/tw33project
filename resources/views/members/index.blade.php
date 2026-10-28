@extends('members.layout')

@section('title', 'Members')

@section('content')
<section class="heading">
    <div><p class="eyebrow">Community directory</p><h1>Member Management</h1><p class="muted">Keep member details organized and easy to find.</p></div>
    <a class="button" href="{{ route('members.create') }}">+ Add member</a>
</section>

@if (session('success'))<p class="alert">{{ session('success') }}</p>@endif

<div class="toolbar">
    <form class="search" method="GET" action="{{ route('members.index') }}">
        <input type="search" name="search" value="{{ $search }}" placeholder="Search by name, category, or level" aria-label="Search members">
        <button class="button" type="submit">Search</button>
    </form>
    <span class="muted">{{ $members->total() }} member{{ $members->total() === 1 ? '' : 's' }}</span>
</div>

<section class="member-grid" aria-label="Members">
    @forelse ($members as $member)
    <article class="member-card">
        <div class="avatar">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
        <h3>{{ $member->name }}</h3>
        <p class="member-email">{{ $member->email }}</p>
        <div class="tags"><span class="tag">{{ $member->membershipCategory?->name ?? $member->category }}</span><span class="tag">{{ $member->membershipLevel?->name ?? $member->level }}</span><span class="status {{ $member->is_active ? '' : 'inactive' }}">{{ $member->is_active ? 'Active' : 'Inactive' }}</span></div>
        <a class="button secondary" href="{{ route('members.show', $member) }}">View profile</a>
    </article>
    @empty
    <p class="empty">No members found. Try a different search or add a new member.</p>
    @endforelse
</section>

{{ $members->links('pagination::simple-default') }}
@endsection
