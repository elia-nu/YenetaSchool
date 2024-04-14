<?php

namespace App\Http\Controllers\api;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogsController extends Controller
{



    public function index()
    {
        $blogs = Blog::all();
        
        if($blogs->isEmpty()) {
            return response()->json(['message' => 'No blogs found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'blogs retrieved successfully', 'status' => 1, 'data' => $blogs]);
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'author_am' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'title_am' => 'required|string|max:255',
            'summary' => 'required|string',
            'summary_am' => 'required|string',
            'description' => 'required|string',
            'description_am' => 'required|string',
            'image' => 'required|image|max:2048', // Assuming you want to allow images up to 2MB
         ]);
        if ($validatedData['message'] ?? false) {
            return response()->json(['message' => 'Message received'], Response::HTTP_OK);
        }

        $blogs = Blog::create($validatedData);
        return response()->json(['message' => 'blogs created successfully', 'status' => 1], Response::HTTP_CREATED);
    }

    // Get a specific blogs by id
    public function show(Blog $blogs)
    {
        return response()->json(['message' => 'blogs retrieved successfully', 'status' => 1, 'data' => $blogs]);
    }
    
    // Get a specific blogs by id
    public function showbyname($name)
    {
        $blogs = Blog::where('title', $name)->first();
        
        if(!$blogs) {
            return response()->json(['message' => 'blogs not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'blogs retrieved successfully', 'status' => 1, 'data' => $blogs]);
    }
    // Update a specific blogs
    public function update(Request $request, Blog $blogs)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'author_am' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'title_am' => 'required|string|max:255',
            'summary' => 'required|string',
            'summary_am' => 'required|string',
            'description' => 'required|string',
            'description_am' => 'required|string',
            'image' => 'required|image|max:2048', // Assuming you want to allow images up to 2MB
     
        ]);

        $blogs->update($validatedData);
        if ($blogs->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $blogs]);
        }
    }
    // Delete a specific blogs
 
    public function destroy(Blog $program)
    {
        $program->delete();
        return response()->json(['message' => 'Program deleted successfully', 'status' => 1]);
    }





    //
}
