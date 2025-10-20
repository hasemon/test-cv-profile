<!DOCTYPE html>
<!-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Manager</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    {{-- Custom JavaScript links (in head for early loading) --}}
    <script src="{{ asset('js/profileValidation.js') }}" defer></script>
    <script src="{{ asset('js/profileInteractions.js') }}" defer></script>
</head>

<body>
    <div id="app">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">Profile Manager</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            {{-- Using route('profile.create') --}}
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
    

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
{{-- 2. ADDED CLOSING BODY TAG --}}
</body>
{{-- 3. ADDED CLOSING HTML TAG --}}
</html>