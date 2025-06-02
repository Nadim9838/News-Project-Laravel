<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Sorting with validation
        $sortField = in_array($request->input('sort'), ['id', 'title', 'description', 'created_at']) 
            ? $request->input('sort') 
            : 'id';
        
        $sortDirection = in_array($request->input('direction'), ['asc', 'desc']) 
            ? $request->input('direction') 
            : 'desc';
        
        $query->orderBy($sortField, $sortDirection);
        
        // Pagination
        $perPage = $request->input('per_page', 10);
        $posts = $query->paginate($perPage);
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.posts_table', compact('posts'))->render()
            ]);
        }
        
        return view('admin.posts', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        
        try {
            $imagePath = $request->file('image')->store('uploads', 'public');
            
            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => basename($imagePath)
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Post $post)
    {
        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    public function edit(Post $post)
    {
        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        
        try {
            $post->title = $request->title;
            $post->description = $request->description;
            
            if ($request->hasFile('image')) {
                // Delete old image
                $oldImagePath = str_replace('uploads/', '', $post->image);
                Storage::disk('public')->delete('uploads/' . $oldImagePath);
                
                // Store new image
                $imagePath = $request->file('image')->store('uploads', 'public');
                $post->image = $imagePath;
            }
            
            $post->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Post $post)
    {
        try {
            // Delete associated image
            $imagePath = str_replace('uploads/', '', $post->image);
            Storage::disk('public')->delete('uploads/' . $imagePath);
            
            $post->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting post: ' . $e->getMessage()
            ], 500);
        }
    }
}