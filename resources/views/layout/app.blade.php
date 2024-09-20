<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('files.index') }}">File Management</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('files.index') }}">Files</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('folders.index') }}">Folders</a>
                </li>
            </ul>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-outline-danger">Logout</a>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
