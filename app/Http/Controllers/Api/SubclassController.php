<?php

namespace App\Http\Controllers\Api;
use App\Models\Subclass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class SubclassController extends Controller
{

    public function index()
    {
        $courses = Subclass::all();
        
        if($courses->isEmpty()) {
            return response()->json(['message' => 'No courses found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Subclass retrieved successfully', 'status' => 1, 'data' => $courses]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Course' => 'required|string|max:255',
            'Course_am' => 'nullable|string|max:255',
        ]);
        if ($validatedData['message'] ?? false) {
            return response()->json(['message' => 'Message received'], Response::HTTP_OK);
        }

        $courses = Subclass::create($validatedData);
        return response()->json(['message' => 'Subclass created successfully', 'status' => 1], Response::HTTP_CREATED);
    }

    // Get a specific Subclass by id
    public function show(Subclass $courses)
    {
        return response()->json(['message' => 'Subclass retrieved successfully', 'status' => 1, 'data' => $courses]);
    }
    
    // Get a specific Subclass by id
    public function showbyname($name)
    {
        $courses = Subclass::where('title', $name)->first();
        
        if(!$courses) {
            return response()->json(['message' => 'Subclass not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Subclass retrieved successfully', 'status' => 1, 'data' => $courses]);
    }
    // Update a specific Subclass
    public function update(Request $request, Subclass $courses)
    {
        $validatedData = $request->validate([   
        'Course' => 'required|string|max:255',
        'Course_am' => 'nullable|string|max:255',
        ]);
        $courses->update($validatedData);
        if ($courses->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $courses]);
        }
    }
    // Delete a specific Subclass
    public function destroy(Subclass $courses)
    {
        $courses->delete();
        return response()->json(['message' => 'Subclass deleted successfully', 'status' => 1]);
    }



    //
}
