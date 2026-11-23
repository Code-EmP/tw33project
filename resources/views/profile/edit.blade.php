<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile | My Tasks</title>
    <style>
        body{margin:0;background:#f7f4ff;color:#302a3d;font:15px system-ui}.card{width:min(100% - 32px,650px);margin:55px auto;padding:34px;border:1px solid #e9e3f3;border-radius:22px;background:#fff;box-shadow:0 14px 35px rgb(99 77 165 / 7%)}h1{margin:0 0 8px;letter-spacing:-.05em}.muted{color:#817991;line-height:1.6}.field{margin:18px 0}label{display:block;margin-bottom:7px;font-weight:700}input,textarea{width:100%;box-sizing:border-box;padding:12px;border:1px solid #ddd6eb;border-radius:10px;font:inherit}textarea{min-height:110px;resize:vertical}.error{margin-top:5px;color:#a24767;font-size:.8rem}.form-actions{display:flex;gap:10px;margin-top:22px}.form-actions button,.add-later{padding:12px 18px;border:0;border-radius:10px;font:inherit;font-weight:700;text-decoration:none;cursor:pointer;transition:transform 160ms ease,box-shadow 160ms ease}.form-actions button{color:#fff;background:#6048a5;box-shadow:0 7px 14px rgb(96 72 165 / 18%)}.add-later{display:inline-flex;align-items:center;color:#6048a5;background:#eee9ff}.form-actions button:hover,.add-later:hover{transform:translateY(-1px)}.form-actions button:active,.add-later:active{transform:scale(.98)}
    </style>
</head>
<body>
@include('partials.navigation')
<main class="card">
    <p class="muted">Welcome to your workspace</p>
    <h1>Complete your profile</h1>
    <p class="muted">Add a few details so your profile is ready to share.</p>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        <div class="field"><label for="name">Name</label><input id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>@error('name')<div class="error">{{ $message }}</div>@enderror</div>
        <div class="field"><label for="bio">About me</label><textarea id="bio" name="bio" placeholder="Tell us a little about yourself" required>{{ old('bio') }}</textarea>@error('bio')<div class="error">{{ $message }}</div>@enderror</div>
        <div class="field"><label for="age">Age</label><input id="age" name="age" type="number" min="13" max="120" value="{{ old('age') }}" required>@error('age')<div class="error">{{ $message }}</div>@enderror</div>
        <div class="field"><label for="location">Location</label><input id="location" name="location" value="{{ old('location') }}" placeholder="City, Country" required>@error('location')<div class="error">{{ $message }}</div>@enderror</div>
        <div class="form-actions">
            <button type="submit">Save profile</button>
            <a class="add-later" href="{{ route('dashboard') }}">Add later</a>
        </div>
    </form>
</main>
</body>
</html>
