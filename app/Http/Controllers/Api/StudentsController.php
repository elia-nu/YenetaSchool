<?php

namespace App\Http\Controllers\api;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class StudentsController extends Controller
{
    public function index()
    {
        $student = Student::all();
        
        if($student->isEmpty()) {
            return response()->json(['message' => 'No student found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Student retrieved successfully', 'status' => 1, 'data' => $student]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'dob' => 'required|date',
            'parent_name' => 'nullable|string|max:255',
            'parent_email' => 'nullable|email',
            'mother_number' => 'required|string|max:255',
            'father_number' => 'required|string|max:255',
            'sex' => 'nullable|string|max:255',
            'course' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_contact_number' => 'nullable|string|max:255',
        ]);
        if ($validatedData['message'] ?? false) {
            return response()->json(['message' => 'Message received'], Response::HTTP_OK);
        }

        $student = Student::create($validatedData);
        return response()->json(['message' => 'Student created successfully', 'status' => 1], Response::HTTP_CREATED);
    }

    // Get a specific Student by id
    public function show(Student $student)
    {
        return response()->json(['message' => 'Student retrieved successfully', 'status' => 1, 'data' => $student]);
    }
    
    // Get a specific Student by id
    public function showbyname($name)
    {
        $student = Student::where('title', $name)->first();
        
        if(!$student) {
            return response()->json(['message' => 'Student not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Student retrieved successfully', 'status' => 1, 'data' => $student]);
    }
    // Update a specific Student
    public function update(Request $request, Student $program)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'dob' => 'required|date',
            'parent_name' => 'nullable|string|max:255',
            'parent_email' => 'nullable|email',
            'mobile_number' => 'required|string|max:255',
            'fixed_number' => 'nullable|string|max:255',
            'course' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_contact_number' => 'nullable|string|max:255',
        ]);
        $program->update($validatedData);
        if ($program->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $program]);
        }
    }
    // Delete a specific Student
    public function destroy(Student $program)
    {
        $program->delete();
        return response()->json(['message' => 'Program deleted successfully', 'status' => 1]);
    }



    //
}
