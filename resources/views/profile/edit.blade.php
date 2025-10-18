<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">

    <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8">
        <h2 class="text-3xl font-bold text-center text-teal-600 mb-6"> Edit Profile</h2>

        <form action="{{ route('profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Name</label>
                <input type="text" name="name" value="{{ $profile->name }}" required
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Gender</label>
                <input type="text" name="gender" value="{{ $profile->gender }}" required
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <!-- Hobby -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Hobby</label>
                <input type="text" name="hobby" value="{{ $profile->hobby }}"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <!-- Image -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Profile Image</label>
                <input type="file" name="image"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300">
                     Update Profile
                </button>
            </div>
        </form>
    </div>

</body>
</html>
