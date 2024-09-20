@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="mb-3">
        <br><br><form action=" {{ route('files.search') }}" method="GET" class="mb-3">
            <input type="text" name="search" placeholder="Search files..." required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <h2>Your Files</h2>
  
    <ul class="list-group mt-3">
    @foreach($folders as $folder)
     
     <li class="list-group-item">{{ $folder->name }}
            <a href="#" class="btn btn-sm btn-danger float-end">Delete</a>
            <ul>
                @foreach($folder->files as $file)
                    <li>
                       {{ $file->name }}
                       
                      
   

                        <!-- <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#renameModal">Rename</a> -->
                        <!-- <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#shareModal">Share</a> -->
                    </li>
                    
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
<!-- Rename Modal -->


<!-- Share Modal -->
<div class="container mt-5">
    <h1 class="text-center"></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Shared Files</h5>
                    <ul>
        @if($sharedFiles && count($sharedFiles) > 0)
            @foreach ($sharedFiles as $fileShare)
                <li>
                <a href="{{ route('files.show', $fileShare->file->id) }}">{{ $fileShare->file->name }}</a>
                     (Shared with you)
                     
                </li>
            @endforeach
        @else
            <li>No shared files found.</li>
        @endif
    </ul>
                </div>
            </div>
        </div>
    
    
</div>
@endsection
