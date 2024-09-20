<?php

namespace App\Http\Controllers;
use App\Http\Requests\FolderRequest;
use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function create(FolderRequest $request)
    {
        $folder = Folder::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Folder created successfully!');
    }

    // View all folders
    public function index()
    {
        $folders = Folder::where('user_id', auth()->id())->with('files')->get();
        return view('folders.index', compact('folders'));
    }

    // Delete folder
    public function delete($id)
    {
        $folder = Folder::findOrFail($id);

        if ($folder->user_id !== auth()->id()) {
            return response()->json(['error' => 'Permission denied'], 403);
        }

        $folder->files()->delete(); // Delete associated files
        $folder->delete();

        return redirect()->back()->with('success', 'Folder deleted successfully!');
    }
}
