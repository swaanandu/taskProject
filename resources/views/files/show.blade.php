@extends('layouts.admin')

@section('content')
<h1>File Details</h1>
<div class="col-12">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $file->name }}</h5>
            <p><strong>Uploaded On:</strong> {{ $file->created_at }}</p>
            <p><strong>Path:</strong> {{ Storage::url($file->path) }}</p>
            <img src="data:image/jpeg;base64,{{ $file->image_data }}" alt="{{ $file->name }}" style="width: 100%; height: auto;">
            <form action="{{ route('files.delete', $file->id) }}" method="POST">
        @csrf
        @method('DELETE')
        
    </form>
    <a href="{{ route('files.index') }}">Back to Files</a>
        </div>
    </div>
</div>

<div>


    
</div>

@endsection
