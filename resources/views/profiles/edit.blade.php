@extends('layouts.app')

@section('content')
<form action="{{ route('profiles.update', $profile) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <input type="file" name="avatar" class="form-control mb-2">
    <input type="text" name="name" value="{{ $profile->name }}" class="form-control mb-2">
    <select name="gender" class="form-control mb-2">
        <option value="Male" {{ $profile->gender=='Male'?'selected':'' }}>Male</option>
        <option value="Female" {{ $profile->gender=='Female'?'selected':'' }}>Female</option>
    </select>
    <input type="text" name="hobbies" value="{{ $profile->hobbies }}" class="form-control mb-2">
    <button class="btn btn-primary">Update</button>
</form>
@endsection
