@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">{{ isset($profile) ? 'Update Your Profile' : 'Create Your Profile' }}</h1>

            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    {{-- RESOLVED: Action points to profile.update or profile.store --}}
                    <form id="profile-form" 
                          action="{{ isset($profile) ? route('profile.update') : route('profile.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        
                        {{-- No @csrf as it's disabled globally --}}
                        @if(isset($profile))
                            @method('PUT')
                        @endif
                        
                        {{-- Hidden input is not strictly necessary but harmless --}}
                        @if(isset($profile))
                            <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                        @endif

                        <div class="mb-3 text-center">
                            <label class="form-label d-block">Profile Photo</label>
                            @php
                                $photoUrl = (isset($profile) && $profile->photo) 
                                        ? Storage::url($profile->photo) 
                                        : asset('images/default-avatar.png');
                            @endphp
                            <img src="{{ $photoUrl }}" 
                                 alt="Profile Photo" 
                                 class="rounded-circle mb-3 border border-secondary" 
                                 style="width: 100px; height: 100px; object-fit: cover;" 
                                 id="photo-preview">
                            
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <div id="photo-error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ $profile->name ?? '' }}" placeholder="Full Name">
                            <div id="name-error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Gender *</label>
                            @php $currentGender = $profile->gender ?? ''; @endphp
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" {{ $currentGender == 'Male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="genderMale">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" {{ $currentGender == 'Female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="genderFemale">Female</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderOther" value="Other" {{ $currentGender == 'Other' ? 'checked' : '' }}>
                                <label class="form-check-label" for="genderOther">Other</label>
                            </div>
                            <div id="gender-error" class="text-danger small mt-1"></div>
                        </div>

                        <div class="mb-4">
                            <label for="hobbies" class="form-label">Hobbies</label>
                            <textarea class="form-control" id="hobbies" name="hobbies" rows="3" 
                                      placeholder="List your hobbies">{{ $profile->hobbies ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ isset($profile) ? 'Update Profile' : 'Create Profile' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection