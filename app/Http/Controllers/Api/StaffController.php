<?php

namespace App\Http\Controllers\api;
use App\Models\Staff;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class StaffController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->query('offset', 0);
        $limit = $request->query('limit', 10);

        $staffQuery = Staff::latest();
        $staffCount = $staffQuery->count();
        $staff = $staffQuery->offset($offset)->limit($limit)->get();
        
        if($staff->isEmpty()) {
            return response()->json(['message' => 'No staff found', 'status' => 0, 'length' => $staffCount]);
        }
        
        return response()->json(['message' => 'Staff retrieved successfully', 'status' => 1, 'data' => $staff, 'length' => $staffCount]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'name_am' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'position_am' => 'required|string|max:255',
            'social_link' => 'nullable|string',
            'details' => 'required|string',
            'details_am' => 'required|string',
            'subtitle' => 'nullable|string|max:255',
            'subtitle_am' => 'nullable|string|max:255',
        ]);
        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['image'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }
        if ($validatedData['message'] ?? false) {
            return response()->json(['message' => 'Message received'], Response::HTTP_OK);
        }

        $staff = Staff::create($validatedData);
        return response()->json(['message' => 'Staff created successfully', 'status' => 1], Response::HTTP_CREATED);
    }

    // Get a specific Staff by id
   
    
    // Get a specific Staff by id
    public function show($name)
    {
        $staff = Staff::where('name', 'like', '%' . $name . '%')->get();
        
        if($staff->isEmpty()) {
            return response()->json(['message' => 'Staff not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Staff retrieved successfully', 'status' => 1, 'data' => $staff]);
    }
    // Update a specific Staff
  
    // Delete a specific Staff
   

    public function update(Request $request, Staff $program)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'name_am' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'position_am' => 'required|string|max:255',
            'social_link' => 'nullable|string',
            'details' => 'required|string',
            'details_am' => 'required|string',
            'subtitle' => 'nullable|string|max:255',
            'subtitle_am' => 'nullable|string|max:255',
        ]);
        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['image'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }
        $program->update($validatedData);
        if ($program->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $program]);
        }
    }
    // Delete a specific program
    public function destroy(Staff $program)
    {
        $program->delete();
        return response()->json(['message' => 'Program deleted successfully', 'status' => 1]);
    }

    //
}
