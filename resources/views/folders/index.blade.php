@extends('layouts.admin')

@section('content')
<h1>Your Folders</h1>

<form action="{{ route('folders.create') }}" method="POST">
    @csrf
    <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Folder Name" required>
    </div>
    <button type="submit" class="btn btn-primary">Create Folder</button>
</form>

<ul class="list-group mt-3">
    @foreach($folders as $folder)
        <li class="list-group-item">
            {{ $folder->name }}
            <form action="{{ route('folders.delete', $folder->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger float-end">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
