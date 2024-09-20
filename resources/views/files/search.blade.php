@extends('layouts.admin')

@section('title', 'File Search')

@section('content')
    <h1>Search Results</h1>

    <form action="{{ route('files.search') }}" method="GET" class="mb-3">
        <input type="text" name="search" placeholder="Search files..." value="{{ old('search', session('searchTerm', '')) }}" required>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @if ($userFiles->isEmpty() && $sharedFiles->isEmpty())
        <p>No files found for your search.</p>
    @else
        <div class="col-12">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Your Files</h5>
            <ul>
            @foreach ($userFiles as $file)
                <li>
                    <h4><a href="{{ route('files.show', $file->id) }}">{{ $file->name }}</a></h4>
                </li>
            @endforeach
        </ul>       
     </div>
    </div>
</div>
        
<div class="col-12">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Shared Files</h5>
            <ul>
            @foreach ($sharedFiles as $file)
                <li>
                    <h4><a href="{{ route('files.show', $file->id) }}">{{ $file->name }}</a></h4>
                </li>
            @endforeach
        </ul>       
     </div>
    </div>
</div>
       
        
    @endif
@endsection
