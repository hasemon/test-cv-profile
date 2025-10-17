@extends('layouts.app')
@section('content')
<form action="{{ route('profiles.store') }}" method="POST" enctype="multipart/form-data" class="card p-4">
    @csrf
    <div class="mb-2">
        <label>Name</label>
        <input name="name" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>Gender</label>
        <select name="gender" class="form-control">
        <option value="male">Male</option><option value="female">Female</option><option value="other">Other</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Hobbies (comma separated)</label>
        <input name="hobbies" class="form-control">
    </div>
    <div class="mb-2">
        <label>Avatar</label>
        <input type="file" name="avatar" class="form-control">
    </div>
    <button class="btn btn-success">Create Profile</button>
</form>
@endsection
