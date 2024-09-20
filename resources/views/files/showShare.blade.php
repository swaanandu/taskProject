@extends('layouts.admin')

@section('content')
<h1>File Details</h1>

<div>
    <h2>{{ $file->name }}</h2>
    <p><strong>Uploaded On:</strong> {{ $file->created_at }}</p>
    <p><strong>Path:</strong> {{ Storage::url($file->path) }}</p>
    <img src="data:image/jpeg;base64,{{ $file->image_data }}" alt="{{ $file->name }}">
    <a href="{{ Storage::url($file->path) }}" download>Download</a>
    <form action="{{ route('files.delete', $file->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</div>

<a href="{{ route('files.index') }}">Back to Files</a>
@endsection
