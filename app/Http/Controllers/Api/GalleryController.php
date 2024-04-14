<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GalleryController extends Controller

{

    public function index()
    {
        $gallery = Gallery::all();
        
        if($gallery->isEmpty()) {
            return response()->json(['message' => 'No gallery found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Gallery retrieved successfully', 'status' => 1, 'data' => $gallery]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'description_am' => 'nullable|string',
            'group_name' => 'required|string|max:255',
            'group_name_am' => 'nullable|string',
            'category' => 'required|string|max:255',
            'category_am' => 'nullable|string',
        ]);
        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['img_url'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }
        if ($validatedData['message'] ?? false) {
            return response()->json(['message' => 'Gallery received'], Response::HTTP_OK);
        }

        $gallery = Gallery::create($validatedData);
        return response()->json(['message' => 'Message created successfully', 'status' => 1], Response::HTTP_CREATED);
    }

    // Get a specific Gallery by id
    public function show(Gallery $gallery)
    {
        return response()->json(['message' => 'Gallery retrieved successfully', 'status' => 1, 'data' => $gallery]);
    }
    
    // Get a specific Gallery by id
    public function showbyname($name)
    {
        $gallery = Gallery::where('title', $name)->first();
        
        if(!$gallery) {
            return response()->json(['message' => 'Gallery not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Gallery retrieved successfully', 'status' => 1, 'data' => $gallery]);
    }
    // Update a specific Gallery
    public function update(Request $request, Gallery $gallery)
    {
        $validatedData = $request->validate([
    
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'description_am' => 'nullable|string',
            'group_name' => 'required|string|max:255',
            'group_name_am' => 'nullable|string',
            'category' => 'required|string|max:255',
            'category_am' => 'nullable|string',
        ]);
        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['img_url'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }
        $gallery->update($validatedData);
        if ($gallery->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $gallery]);
        }
    }
    // Delete a specific Gallery

    public function destroy(Gallery $program)
    {
        $program->delete();
        return response()->json(['message' => 'Program deleted successfully', 'status' => 1]);
    }


    //
}
