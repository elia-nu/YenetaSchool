<?php

namespace App\Http\Controllers\api;
use App\Models\Testimonial;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $testimonial = Testimonial::offset($offset)->limit($limit)->latest()->get(); // Fetch testimonials in descending order
        
        $messagesCount = Testimonial::count(); // Count all testimonials
        
        if($testimonial->isEmpty()) {
            return response()->json(['message' => 'No testimonial found', 'status' => 0 , 'length' => $messagesCount]);
        }
        
        return response()->json(['message' => 'Testimonial retrieved successfully', 'status' => 1, 'data' => $testimonial, 'length' => $messagesCount]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            
            'author' => 'required|string|max:255',
            'author_am' => 'required|string|max:255',
            'professional' => 'required|string|max:255',
            'professional_am' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['image'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }

        if ($validatedData['message'] ?? false) {
            return response()->json(['message' => 'Message received'], Response::HTTP_OK);
        }

        $testimonial = Testimonial::create($validatedData);
        return response()->json(['message' => 'Testimonial created successfully', 'status' => 1], Response::HTTP_CREATED);
    }

    // Get a specific Testimonial by id
    public function show(Testimonial $testimonial)
    {
        return response()->json(['message' => 'Testimonial retrieved successfully', 'status' => 1, 'data' => $testimonial]);
    }
    
    // Get a specific Testimonial by id
    public function showbyname($name)
    {
        $testimonial = Testimonial::where('title', $name)->first();
        
        if(!$testimonial) {
            return response()->json(['message' => 'Testimonial not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Testimonial retrieved successfully', 'status' => 1, 'data' => $testimonial]);
    }
    // Update a specific Testimonial
    public function update(Request $request, Testimonial $testimonial)
    {
        $validatedData = $request->validate([
        
            'author' => 'required|string|max:255',
            'author_am' => 'required|string|max:255',
            'professional' => 'required|string|max:255',
            'professional_am' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['image'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }

        $testimonial->update($validatedData);
        if ($testimonial->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $testimonial]);
        }
    }
    // Delete a specific Testimonial
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return response()->json(['message' => 'Testimonial deleted successfully', 'status' => 1]);
    }




    //
}
