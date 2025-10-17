<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <h1 class="bg-[rgba(45,197,159,0.88)] text-white text-4xl px-6 py-2 text-center">
        Create Profile
    </h1>
<form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white mt-10 p-8 rounded-2xl shadow-lg w-full max-w-md space-y-5 border border-gray-200 align-middle mx-auto">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-1">Name</label>
            <input type="text" name="name" placeholder="Enter your name" required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:outline-none">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Gender</label>
            <input type="text" name="gender" placeholder="Enter your gender" required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:outline-none">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Hobby</label>
            <input type="text" name="hobby" placeholder="Enter your hobby"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:outline-none">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Profile Image</label>
            <input type="file" name="image"
                   class="w-full text-gray-700 border border-gray-300 rounded-lg p-2 bg-gray-50 focus:ring-2 focus:ring-emerald-400 focus:outline-none">
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 shadow-md">
                Create Profile
            </button>
        </div>
    </form>

</body>
</html>
