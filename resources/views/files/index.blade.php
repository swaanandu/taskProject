@extends('layouts.admin')

@section('content')
<h1>Your Files</h1>

<form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="file">Upload File</label>
        <input type="file" class="form-control" name="file" id="file" required>
        
        @if ($errors->has('file'))
            <span class="text-danger">{{ $errors->first('file') }}</span>
        @endif
    </div>
    <div class="mb-3">
        <select name="folder_id" required class="form-select">
            <option value="">Select Folder</option>
            @foreach($folders as $folder)
                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
</form>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<h2>Your Folders</h2>
<div class="mb-3">
<form action="{{ route('files.search') }}" method="GET" class="mb-3">
    <input type="text" name="search" placeholder="Search files..." required>
    <button type="submit" class="btn btn-primary">Search</button>
</form>
</div>
<!-- @if($folders->isEmpty())
    <p>No folders found.</p>
@else -->
<ul class="list-group mt-3">
    @foreach($folders as $folder)
     
     <li class="list-group-item"><h5>{{ $folder->name }}</h5>
            <a href="#" class="btn btn-sm btn-danger float-end">Delete</a>
            <ul>
                @foreach($folder->files as $file)
                    <li>
                    <h5><a href="{{ route('files.show', $file->id) }}">{{ $file->name }}</a></h5>

                        <form action="{{ route('files.rename', $file) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="text" name="new_name" placeholder="New name" required>
                        <button type="submit">Rename</button>
                    </form><br><br>
            <form action="{{ route('files.share') }}" method="POST">
                 @csrf
                   <input type="hidden" name="file_id" value="{{ $file->id }}">
                   <select name="user_ids[]" multiple required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <button type="submit">Share</button>
            </form><br>

    
    <form action="{{ route('files.move') }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="file_id" value="{{ $file->id }}">
                    <select name="folder_id" required>
                        <option value="">Select Folder</option>
                        @foreach($folders as $folder)
                            <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Move</button>
                </form>

                <form action="{{ route('files.delete', $file->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form><br><br>
                        <!-- <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#renameModal">Rename</a> -->
                        <!-- <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#shareModal">Share</a> -->
                    </li>
                    
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
<!-- @endif -->
<!-- Rename Modal -->


<!-- Share Modal -->

  

@endsection
