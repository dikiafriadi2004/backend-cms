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
        
        // Add headers to allow iframe loading
        return response()
            ->view('admin.filemanager.index', compact('type', 'editor'))
            ->header('X-Frame-Options', 'SAMEORIGIN')
            ->header('Content-Security-Policy', "frame-ancestors 'self'");
    }

    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max
            ]);

            $file = $request->file('file');
            $type = $request->get('type', 'image');
            
            // Determine folder based on file type - use simple structure
            if ($type === 'image' || in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                $folder = 'images';
            } else {
                $folder = 'files';
            }
            
            // Ensure the folder exists
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
            
            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Store file
            $path = $file->storeAs($folder, $filename, 'public');
            
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path),
                'path' => $path,
                'filename' => $filename,
                'size' => $file->getSize(),
                'type' => $file->getMimeType(),
                'message' => 'File uploaded successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function browse(Request $request)
    {
        try {
            $type = $request->get('type', 'image');
            $folder = $type === 'image' ? 'images' : 'files';
            
            $files = [];
            
            // Ensure the folder exists
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
            
            if (Storage::disk('public')->exists($folder)) {
                $allFiles = Storage::disk('public')->files($folder);
                
                foreach ($allFiles as $file) {
                    try {
                        $files[] = [
                            'name' => basename($file),
                            'url' => asset('storage/' . $file),
                            'path' => $file,
                            'size' => Storage::disk('public')->size($file),
                            'modified' => Storage::disk('public')->lastModified($file),
                            'type' => Storage::disk('public')->mimeType($file)
                        ];
                    } catch (\Exception $e) {
                        // Skip files that can't be read
                        continue;
                    }
                }
            }
            
            // Sort by modified date (newest first)
            usort($files, function($a, $b) {
                return $b['modified'] - $a['modified'];
            });
            
            return response()->json([
                'success' => true,
                'files' => $files,
                'folder' => $folder,
                'count' => count($files)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading files: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $path = $request->get('path');
            
            if (!$path) {
                return response()->json([
                    'success' => false,
                    'message' => 'File path is required'
                ], 400);
            }
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                return response()->json([
                    'success' => true,
                    'message' => 'File deleted successfully'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}