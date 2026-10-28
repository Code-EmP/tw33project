@extends('members.layout')

@section('title', 'Add Member')

@section('content')
<div class="heading"><div><p class="eyebrow">Member management</p><h1>Add new member</h1><p class="muted">Create a profile for someone in your community.</p></div><a class="button secondary" href="{{ route('members.index') }}">Back to members</a></div>
<div class="form-card">
    <form method="POST" action="{{ route('members.store') }}">
        @csrf
        @include('members.form')
        <div class="form-actions"><button class="button" type="submit">Save member</button><a class="button secondary" href="{{ route('members.index') }}">Cancel</a></div>
    </form>
</div>
@endsection
