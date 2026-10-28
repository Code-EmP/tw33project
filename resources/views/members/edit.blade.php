@extends('members.layout')

@section('title', 'Edit Member')

@section('content')
<div class="heading"><div><p class="eyebrow">Member management</p><h1>Edit member</h1><p class="muted">Update {{ $member->name }}'s details.</p></div><a class="button secondary" href="{{ route('members.show', $member) }}">Back to profile</a></div>
<div class="form-card">
    <form method="POST" action="{{ route('members.update', $member) }}">
        @csrf @method('PUT')
        @include('members.form', ['member' => $member])
        <div class="form-actions"><button class="button" type="submit">Save changes</button><a class="button secondary" href="{{ route('members.show', $member) }}">Cancel</a></div>
    </form>
</div>
@endsection
