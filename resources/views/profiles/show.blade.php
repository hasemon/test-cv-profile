@extends('layouts.app')
@section('content')
<div class="card mb-3 p-3">
    @if($profile->avatar)
        <img src="{{ asset('storage/'.$profile->avatar) }}" width="150" class="mb-2 rounded">
    @endif
    <h4>{{ $profile->name }}</h4>
    <p><b>Gender:</b> {{ ucfirst($profile->gender) }}</p>
    <p><b>Hobbies:</b> {{ $profile->hobbies }}</p>
</div>

{{-- Education Section --}}
<div class="card mb-3 p-3">
    <h5>Education</h5>
    <form action="{{ route('profiles.educations.store',$profile) }}" method="POST" class="row g-2">
        @csrf
        <div class="col-md-3"><input name="degree" class="form-control" placeholder="Degree" required></div>
        <div class="col-md-3"><input name="institute" class="form-control" placeholder="Institute" required></div>
        <div class="col-md-3"><input type="date" name="start_date" class="form-control" required></div>
        <div class="col-md-2"><input name="end_year" class="form-control" placeholder="End Year" required></div>
        <div class="col-md-1"><button class="btn btn-primary">Add</button></div>
    </form>
    <table class="table table-bordered mt-3">
    <tr><th>Degree</th><th>Institute</th><th>Start</th><th>End</th><th></th></tr>
    @foreach($profile->educations as $edu)
        <tr>
            <td>{{ $edu->degree }}</td>
            <td>{{ $edu->institute }}</td>
            <td>{{ $edu->start_date }}</td>
            <td>{{ $edu->end_year }}</td>
            <td><a href="{{ route('educations.edit',$edu) }}" class="btn btn-sm btn-warning">Edit</a></td>
        </tr>
        @endforeach
    </table>
</div>

{{-- Comment Section --}}
{{-- <div class="card p-3">
    <h5>Comments</h5>
    <form action="{{ route('comments.store',$profile) }}" method="POST" enctype="multipart/form-data" class="row g-2 mb-3">
        @csrf
        <div class="col-md-3"><input name="commenter_name" class="form-control" placeholder="Your Name"></div>
        <div class="col-md-5"><input name="text" class="form-control" placeholder="Comment text"></div>
        <div class="col-md-3"><input type="file" name="image" class="form-control"></div>
        <div class="col-md-1"><button class="btn btn-success">Post</button></div>
    </form>
    @foreach($profile->comments as $c)
    <div class="border p-2 mb-2">
        <strong>{{ $c->commenter_name ?? 'Anonymous' }}</strong>
        <p>{{ $c->text }}</p>
        @if($c->image)
        <img src="{{ asset('storage/'.$c->image) }}" width="120">
        @endif
    </div>
    @endforeach
</div> --}}
@endsection
