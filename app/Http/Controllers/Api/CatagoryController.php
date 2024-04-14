<?php

namespace App\Http\Controllers\Api;
use App\Models\Catagory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class CatagoryController extends Controller
{

    public function index()
    {
        $courses = Catagory::all();
        
        if($courses->isEmpty()) {
            return response()->json(['message' => 'No courses found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Subclass retrieved successfully', 'status' => 1, 'data' => $courses]);
    }

    public function store(Request $request)
    {
          $validatedData = $request->validate([
            'Catagory' => 'required|string|max:255',
       
        ]);
    
        
    
    
        // Assuming other fields are directly assignable
        $program = Catagory::create($validatedData);
    
        return response()->json(['message' => 'Program created successfully', 'status' => 1], Response::HTTP_CREATED);
    }
    // Get a specific Subclass by id
    public function show(Catagory $courses)
    {
        return response()->json(['message' => 'Subclass retrieved successfully', 'status' => 1, 'data' => $courses]);
    }
    
    // Get a specific Subclass by id
    public function showbyname($name)
    {
        $courses = Catagory::where('title', $name)->first();
        
        if(!$courses) {
            return response()->json(['message' => 'Subclass not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Subclass retrieved successfully', 'status' => 1, 'data' => $courses]);
    }
    // Update a specific Subclass
    public function update(Request $request, Catagory $courses)
    {
        $validatedData = $request->validate([   
        'Catagory' => 'required|string|max:255',
         ]);
        $courses->update($validatedData);
        if ($courses->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $courses]);
        }
    }
    // Delete a specific Subclass
    public function destroy(Catagory $courses)
    {
        $courses->delete();
        return response()->json(['message' => 'Subclass deleted successfully', 'status' => 1]);
    }



    //
}
