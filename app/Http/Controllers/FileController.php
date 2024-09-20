<?php

namespace App\Http\Controllers;
use App\Http\Requests\FileRequest;
use App\Http\Requests\ShareRequest;
use App\Models\File;
use App\Models\Folder;
use App\Models\FileShare;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class FileController extends Controller
{
    public function upload(FileRequest $request)
    {
        $path = $request->file('file')->store('uploads/' . auth()->id());
        $imageData = base64_encode(file_get_contents($request->file('file')->getRealPath()));
        $file = File::create([
            'name' => $request->file->getClientOriginalName(),
            'path' => $path,
            'folder_id' => $request->folder_id,
            'user_id' => auth()->id(),
            'image_data' => $imageData,
        ]); 

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

    // View files
    public function index()
    {
        $folders = Folder::where('user_id', auth()->id())->with('files')->get();
        $users = User::where('id', '!=', auth()->id())->get();
        $files = Auth::user()->files; // User's own files
        $sharedFiles=FileShare::where('user_id', auth()->id())->with('file')->get();
        return view('files.index', compact('folders', 'users','files', 'sharedFiles'));
    }

    // Rename file
    public function rename(Request $request, File $file)
    {
        $request->validate(['new_name' => 'required|string|max:255']);
        $newName = $request->input('new_name');

        // Rename file on the server

        $newPath = "uploads/{$file->user_id}/{$newName}";
        Storage::disk('public')->move($file->path, $newPath);

        // Update the database
        $file->name = $newName;
        $file->path = $newPath;
        $file->save();

        return back()->with('success', 'File renamed successfully!');
    }
    // Delete file
    public function delete($id)
    {
        $file = File::findOrFail($id);

        if ($file->user_id !== auth()->id()) {
            return response()->json(['error' => 'Permission denied'], 403);
        }

        Storage::delete($file->path);
        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }

    // Move file to another folder
    public function move(Request $request)
    {
       $request->validate([
            'file_id' => 'required|exists:files,id',
            'folder_id' => 'required|exists:folders,id',
       ]);

    // Find the file and update its folder_id
    $file = File::find($request->file_id);
    $file->folder_id = $request->folder_id;
    $file->save();

    return redirect()->route('files.index')->with('success', 'File moved successfully.');
   }


    // Search files
    public function search(Request $request)
    {
        $request->validate(['search' => 'required|string']);

        $searchTerm = $request->input('search');

        // Fetch files based on the search term
        $userFiles = Auth::user()->files()->where('name', 'like', '%' . $searchTerm . '%')->get();
        $sharedFiles = Auth::user()->sharedFiles()->where('files.name', 'like', '%' . $searchTerm . '%')->get();

        // Store search term and results in session
        session([
            'searchTerm' => $searchTerm,
            'userFiles' => $userFiles,
            'sharedFiles' => $sharedFiles,
        ]);

        // Redirect to results page
        return redirect()->route('files.search.results');
    }
    
    public function searchResults()
    {
        // Retrieve search term and results from session
        $userFiles = session('userFiles', collect());
        $sharedFiles = session('sharedFiles', collect());
        $searchTerm = session('searchTerm', '');
    
        return view('files.search', compact('userFiles', 'sharedFiles', 'searchTerm'));
    }
    // Share file
    public function shareFile(ShareRequest $request)
    {
        $file = File::find($request->file_id);

        if (!$file) {
            return redirect()->back()->withErrors(['error' => 'File not found.']);
        }

        if ($file->user_id !== auth()->id()) {
            return response()->json(['error' => 'Permission denied'], 403);
        }

        foreach ($request->user_ids as $userId) {
            FileShare::updateOrCreate(
                ['file_id' => $file->id, 'user_id' => $userId],
                ['permission' => 'read-only']
            );
        }

        return redirect()->back()->with('success', 'File shared successfully!');
    }
    public function shared()
    {
        $folders = Folder::where('user_id', auth()->id())->with('files')->get();
        $users = User::where('id', '!=', auth()->id())->get();
        $files = Auth::user()->files; // User's own files
        $sharedFiles=FileShare::where('user_id', auth()->id())->with('file')->get();
        return view('files.shared', compact('folders', 'users','files', 'sharedFiles'));
    }

    public function show($id)
      {
        $file = File::findOrFail($id);
        // Ensure the file exists

        if (!Storage::exists($file->path)) {
            return redirect()->route('files.index')->with('error', 'File not found.');
        }
    
        // Get file size
        $fileSize = Storage::size($file->path);
        return view('files.show', compact('file', 'fileSize'));
    }

    public function demo(){
        return view('demo');
    }

}