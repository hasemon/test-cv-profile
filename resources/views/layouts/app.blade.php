<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Manager</title>

    {{-- Bootstrap CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9O+r+R9T+T+d+D9vK0N/Gz2j/c/T7WfF+M2A5N4/D8w4T" crossorigin="anonymous">
    
    {{-- Custom JavaScript links (in head for early loading) --}}
    <script src="{{ asset('js/profileValidation.js') }}" defer></script>
    <script src="{{ asset('js/profileInteractions.js') }}" defer></script>
</head>
{{-- 1. ADDED OPENING BODY TAG --}}
<body>
    <div id="app">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                {{-- Resolved: Using route('home') --}}
                <a class="navbar-brand" href="{{ route('home') }}">Profile Manager</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            {{-- Resolved: Using route('profile.create') --}}
                            <a class="btn btn-outline-light" href="{{ route('profile.create') }}">Create/Edit Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Main Content Area --}}
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    {{-- Bootstrap JS CDN (must be before closing </body>) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
{{-- 2. ADDED CLOSING BODY TAG --}}
</body>
{{-- 3. ADDED CLOSING HTML TAG --}}
</html>