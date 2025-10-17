@extends('layouts.app')
@section('content')
<a href="{{ route('profiles.create') }}" class="btn btn-primary mb-3">Create New Profile</a>

<div class="row">
@foreach($profiles as $profile)
    <div class="col-md-4 mb-3">
        <div class="card">
            @if($profile->avatar)
            <img src="{{ asset('storage/'.$profile->avatar) }}" class="card-img-top" style="height:200px;object-fit:cover;">
            @endif
            <div class="card-body">
            <h5>{{ $profile->name }}</h5>
            <p>{{ ucfirst($profile->gender) }}</p>
            <a href="{{ route('profiles.show',$profile) }}" class="btn btn-sm btn-info">View</a>
            <a href="{{ route('profiles.edit',$profile) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('profiles.destroy',$profile) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this profile?')">Delete</button>
            </form>

                {{-- Comment Section --}}
                <div class="card p-3">
                    <h5>Comments</h5>
                    <form action="{{ route('comments.store',$profile) }}" method="POST" enctype="multipart/form-data" class="row g-2 mb-3">
                        @csrf
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
                </div>

            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
