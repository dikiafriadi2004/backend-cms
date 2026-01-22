<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'image');
        $editor = $request->get('editor', '');
        
        return view('admin.filemanager.index', compact('type', 'editor'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $type = $request->get('type', 'image');
        
        // Determine folder based on file type
        if ($type === 'image' || in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $folder = 'images';
        } else {
            $folder = 'files';
        }
        
        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Store file
        $path = $file->storeAs("uploads/{$folder}", $filename, 'public');
        
        return response()->json([
            'success' => true,
            'url' => Storage::url($path),
            'path' => $path,
            'filename' => $filename,
            'size' => $file->getSize(),
            'type' => $file->getMimeType()
        ]);
    }

    public function browse(Request $request)
    {
        $type = $request->get('type', 'image');
        $folder = $type === 'image' ? 'uploads/images' : 'uploads/files';
        
        $files = [];
        
        if (Storage::disk('public')->exists($folder)) {
            $allFiles = Storage::disk('public')->files($folder);
            
            foreach ($allFiles as $file) {
                $files[] = [
                    'name' => basename($file),
                    'url' => Storage::url($file),
                    'path' => $file,
                    'size' => Storage::disk('public')->size($file),
                    'modified' => Storage::disk('public')->lastModified($file),
                    'type' => Storage::disk('public')->mimeType($file)
                ];
            }
        }
        
        // Sort by modified date (newest first)
        usort($files, function($a, $b) {
            return $b['modified'] - $a['modified'];
        });
        
        return response()->json([
            'success' => true,
            'files' => $files
        ]);
    }

    public function delete(Request $request)
    {
        $path = $request->get('path');
        
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'File not found']);
    }
}