@extends('members.layout')

@section('title', $member->name)

@section('content')
@if (session('success'))<p class="alert">{{ session('success') }}</p>@endif
<div class="profile-card">
    <div class="profile-heading"><div class="avatar">{{ strtoupper(substr($member->name, 0, 1)) }}</div><div><p class="eyebrow">Member profile</p><h1>{{ $member->name }}</h1></div></div>
    <div class="details">
        <div><p class="detail-label">Email address</p><p class="detail-value">{{ $member->email }}</p></div>
        <div><p class="detail-label">Status</p><p class="detail-value">{{ $member->is_active ? 'Active' : 'Inactive' }}</p></div>
        <div><p class="detail-label">Category</p><p class="detail-value">{{ $member->category }}</p></div>
        <div><p class="detail-label">Level</p><p class="detail-value">{{ $member->level }}</p></div>
        <div><p class="detail-label">Joined</p><p class="detail-value">{{ $member->created_at->format('M j, Y') }}</p></div>
    </div>
    <div class="actions">
        <a class="button" href="{{ route('members.edit', $member) }}">Edit details</a>
        @if ($member->is_active)
        <form class="inline" method="POST" action="{{ route('members.deactivate', $member) }}">@csrf @method('PATCH')<button class="button secondary" type="submit">Deactivate</button></form>
        @endif
        <form class="inline" method="POST" action="{{ route('members.destroy', $member) }}" onsubmit="return confirm('Delete this member permanently?')">@csrf @method('DELETE')<button class="button danger" type="submit">Delete</button></form>
    </div>
</div>
@endsection
