<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\programs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;


class ProgramsController extends Controller
{
    // Get all programs
    public function index()
    {
        $programs = programs::all();
        
        if($programs->isEmpty()) {
            return response()->json(['message' => 'No programs found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Programs retrieved successfully', 'status' => 1, 'data' => $programs]);
    }
    // Create a new program
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'title_am' => 'sometimes|string|max:255',
        'description' => 'required|string',
        'description_am' => 'sometimes|string',
        'price' => 'required|numeric',
        'teachers' => 'required|string', // Adjust based on whether it's a string or array
        'teacher_am' => 'sometimes|string',
        'Course' => 'required|string',
        'start_date' => 'required',
        'end_date' => 'required', // Add specific date validation as needed
        // Change 'img_url' to 'image' and expect a file instead of a URL
 // This line changes to accept an image file
    ]);

    // Handle the image upload
    if ($request->hasFile('img')) {
        $image = $request->file('img'); // Assuming single file upload for simplicity
        $path = $image->store('public/images');
        $validatedData['img_url'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
    }


    // Assuming other fields are directly assignable
    $program = Programs::create($validatedData);

    return response()->json(['message' => 'Program created successfully', 'status' => 1], Response::HTTP_CREATED);
}

    // Get a specific program by id
    public function show(programs $program)
    {
        return response()->json(['message' => 'Program retrieved successfully', 'status' => 1, 'data' => $program]);
    }
    
    // Get a specific program by id
    public function showbyname($name)
    {
        $program = programs::where('title', $name)->first();
        
        if(!$program) {
            return response()->json(['message' => 'Program not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Program retrieved successfully', 'status' => 1, 'data' => $program]);
    }
    // Update a specific program
    public function update(Request $request, programs $program)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'title_am' => 'sometimes|string|max:255',
            'description' => 'required|string',
            'description_am' => 'sometimes|string',
            'price' => 'required|numeric',
            'teachers' => 'required|string', // Adjust based on whether it's a string or array
            'teacher_am' => 'sometimes|string',
            'Course' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',  // Add specific date validation as needed
            // Change 'img_url' to 'image' and expect a file instead of a URL
     // This line changes to accept an image file
        ]);
    
        // Handle the image upload
        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['img_url'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }
    
    
        $program->update($validatedData);
        if ($program->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $program]);
        }
    }
    // Delete a specific program
    public function destroy(programs $program)
    {
        $program->delete();
        return response()->json(['message' => 'Program deleted successfully', 'status' => 1]);
    }
}
