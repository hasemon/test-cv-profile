@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif

            <div class="card mb-5 shadow-lg">
                <div class="card-body p-5">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-4">
                        <img src="{{ $profile->photo ? Storage::url($profile->photo) : asset('images/default-avatar.png') }}" 
                             alt="{{ $profile->name }}" 
                             class="rounded-circle border border-primary border-3" style="width: 100px; height: 100px; object-fit: cover;">
                        
                        <div class="ms-4 flex-grow-1">
                            <h1 class="card-title display-5 fw-bold">{{ $profile->name }}</h1>
                            <p class="text-muted mb-1">Gender: {{ $profile->gender }}</p>
                            <p class="text-secondary">Hobbies: {{ $profile->hobbies ?? 'N/A' }}</p>
                        </div>

                        <div class="d-flex flex-column align-items-end">
                            <a href="{{ route('profile.create') }}" class="btn btn-warning btn-sm mb-2">Edit Profile Info</a>
                            
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProfileModal">
                                Delete Profile
                            </button>
                        </div>
                    </div>

                    {{-- Education Section --}}
                    <h2 class="h4 mt-5 mb-3 border-bottom pb-2">Educational Details</h2>
                    <div id="education-list" class="list-group mb-4">
                        @forelse($profile->education as $edu)
                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 fw-semibold">{{ $edu->degree }} from {{ $edu->institute }}</p>
                                    <p class="mb-1 text-muted small">
                                        Start: {{ $edu->start_date }} | End: {{ $edu->end_year }}
                                    </p>
                                </div>
                                <form action="{{ route('education.destroy', $edu) }}" method="POST" onsubmit="return confirm('Confirm deletion?')">
                                    {{-- No @csrf --}}
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">No educational details added yet.</div>
                        @endforelse
                    </div>

                    {{-- Add Education Form --}}
                    <div class="p-4 border rounded bg-light mb-5">
                        <h3 class="h5 mb-3">Add New Education</h3>
                        <form id="education-form" action="{{ route('education.store') }}" method="POST">
                            {{-- No @csrf --}}
                            <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <input type="text" name="degree" id="degree" placeholder="Degree" class="form-control">
                                    <div id="degree-error" class="text-danger small mt-1"></div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="institute" id="institute" placeholder="Institute" class="form-control">
                                    <div id="institute-error" class="text-danger small mt-1"></div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="start_date" id="start_date" placeholder="Start Date (DD/MM/YY)" class="form-control">
                                    <div id="start_date-error" class="text-danger small mt-1"></div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="end_year" id="end_year" placeholder="End Year (YYYY)" class="form-control">
                                    <div id="end_year-error" class="text-danger small mt-1"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Add Education</button>
                        </form>
                    </div>

                    {{-- Comment Section --}}
                    <h2 class="h4 mt-5 mb-3 border-bottom pb-2">Comments</h2>
                    <div id="comments-list" class="mb-4">
                        @forelse($profile->comments as $comment)
                            <div class="card card-body mb-3 shadow-sm">
                                <p class="mb-1 fw-bold">{{ $comment->author_name }} <span class="text-muted small float-end">({{ $comment->created_at->diffForHumans() }})</span></p>
                                @if($comment->content)
                                    <p class="mb-1">{{ $comment->content }}</p>
                                @endif
                                @if($comment->image)
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($comment->image) }}" alt="Comment Image" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="alert alert-secondary">No comments yet.</div>
                        @endforelse
                    </div>

                    {{-- Add Comment Form --}}
                    <div class="p-4 border rounded bg-light">
                        <h3 class="h5 mb-3">Leave a Comment</h3>
                        <form id="comment-form" action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
                            {{-- No @csrf --}}
                            <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                            
                            <div class="mb-3">
                                <label for="author_name" class="form-label">Your Name</label>
                                <input type="text" name="author_name" id="author_name" value="Anonymous" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Comment Text</label>
                                <textarea name="content" id="content" rows="3" placeholder="Enter text or attach an image..." class="form-control"></textarea>
                                <div id="content-error" class="text-danger small mt-1"></div>
                            </div>

                            <div class="mb-3">
                                <label for="comment_image" class="form-label">Comment Image (Optional)</label>
                                <input type="file" name="image" id="comment_image" accept="image/*" class="form-control">
                                <div id="comment_image-error" class="text-danger small mt-1"></div>
                                <img src="#" alt="Image Preview" class="img-fluid mt-2 d-none" style="max-height: 100px; object-fit: contain;" id="comment_image-preview">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteProfileModal" tabindex="-1" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProfileModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you absolutely sure you want to delete this profile? This action is irreversible and will remove all associated data (education, comments, photos).
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Cancel</button>
                <form action="{{ route('profile.delete') }}" method="POST" class="d-inline">
                    {{-- No @csrf --}}
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection