@extends('layout.master')
@section('title', 'My Profile')

@section('content')
    <h1 class="bg-[rgba(45,197,159,0.88)] text-white text-4xl px-6 py-2 text-center">
        my profile
    </h1>

    @if($profile)
        <div class="max-w-3xl w-full bg-lime-100 mx-auto text-center text-gray-700 rounded-2xl shadow-lg p-8 mt-1">
    <!-- Profile Image -->
    <img class="rounded-full mx-auto w-32 h-32 object-cover border-4 border-teal-400"
         src="{{ $profile->image ? asset('storage/'.$profile->image) : 'https://via.placeholder.com/150' }}"
         alt="Profile Image">

    <!-- Name -->
    <h3 class="text-2xl font-bold mt-4">Name: {{ $profile->name }}</h3>

    <!-- Gender & Hobby -->
    <p class="mt-2 text-gray-600">Gender: {{ $profile->gender }}</p>
    <p class="mt-1 text-gray-600">Hobby: {{ $profile->hobby }}</p>

    <!-- Edit Button -->
    <a href="{{ route('profile.edit', $profile->id) }}"
       class="inline-block mt-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300">
       Edit
    </a>
</div>




        <div class="bg-white shadow-lg rounded-2xl w-full max-w-3xl p-3 align-middle mx-auto mt-10 mb-10">
        <h2 class="text-3xl font-bold text-center text-teal-600 mb-6"></h2>

        <!-- Education Section -->
        <div class="mb-10 align-middle mx-auto">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Education</h3>
            <ul class="space-y-3">
                @foreach($profile->educations as $edu)
                    <li class="bg-gray-50 p-4 rounded-lg flex justify-between items-center shadow-sm">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $edu->degree }}</p>
                            <p class="text-sm text-gray-600">{{ $edu->institute }} ({{ $edu->session }} - {{ $edu->ending }})</p>
                        </div>
                        <form action="{{ route('education.delete', $edu->id) }}" method="POST" onsubmit="return confirm('Delete this education?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <!-- Add Education Form -->
            <form action="{{ route('education.store') }}" method="POST" class="mt-6 bg-gray-50 p-4 rounded-lg shadow-sm space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="degree" placeholder="Degree" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-400">
                    <input type="text" name="institute" placeholder="Institute" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-400">
                    <input type="text" name="session" placeholder="Session" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-400">
                    <input type="text" name="ending" placeholder="Ending" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-400">
                </div>
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg font-semibold">Add Education</button>
            </form>
        </div>

        <!-- Delete Profile -->
        <form action="{{ route('profile.destroy', $profile->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this profile?')" class="mb-10 text-center">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold">Delete Profile</button>
        </form>

        <!-- Comments Section -->
        <div>
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Comments</h3>
            <ul class="space-y-4">
                @foreach($profile->comments as $comment)
                    <li class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $comment->commenter_name ?? 'Anonymous' }}
                                </p>
                                <p class="text-gray-700">{{ $comment->comment }}</p>
                                @if($comment->image)
                                    <img src="{{ asset('storage/'.$comment->image) }}" width="60" class="mt-2 rounded-lg border">
                                @endif
                            </div>
                            <form action="{{ route('comment.delete', $comment->id) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Add Comment Form -->
            <form action="{{ route('comment.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 bg-gray-50 p-4 rounded-lg shadow-sm space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="commenter_name" placeholder="Your Name" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-400">
                    <input type="text" name="comment" placeholder="Comment" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-400">
                    <input type="file" name="image" class="col-span-2 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-400">
                </div>
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg font-semibold">Add Comment</button>
            </form>
        </div>
    </div>
    @else
        <p class="text-center bg-red-500 text-white">No profile found. <a href="{{ route('profile.create') }}" class="bg-green-500 p-1 m-1 rounded-2xl">Create Profile</a></p>
    @endif

@endsection
