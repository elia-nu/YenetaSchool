<?php

namespace App\Http\Controllers\api;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class StudentsController extends Controller
{ 
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $student = Student::offset($offset)->limit($limit)->latest()->get();
        $messagesCount = Student::count();
        if($student->isEmpty()) {
            return response()->json(['message' => 'No student found', 'status' => 0 ]);
        }
        
        return response()->json(['message' => 'Student retrieved successfully', 'status' => 1, 'data' => $student, 'length' => $messagesCount]);
    }
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'dob' => 'required|date',
                'email' => 'required|email|unique:students',
                'parent_name' => 'nullable|string|max:255',
                'parent_email' => 'nullable|email',
                'mobile_number' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'sex' => 'nullable|string|max:255',
                'address' => 'required|string|max:255',
                'emergency_contact' => 'nullable|string|max:255',
                'emergency_contact_number' => 'nullable|string|max:255',
            ]);
           
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($validatedData['message'] ?? false) {
            return response()->json(['message' => 'Message received'], Response::HTTP_OK);
        }

        function generateUniqueQqwId() {
            // Generate a random string
            $randomString = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8)); // Adjust the length as needed
            
            // Form the unique ID starting with "qqw" and appending the random string
            $qqwId = 'YE' . $randomString;
            
            // Check if the ID already exists, generate a new one if it does
            while (Student::where('uuid', $qqwId)->exists()) {
                $randomString = substr(md5(uniqid(mt_rand(), true)), 0, 8);
                $qqwId = 'Yene' . $randomString;
            }
        
            return $qqwId;
        }

        $uniqueQqwId = generateUniqueQqwId();
        $validatedData['uuid'] = $uniqueQqwId;
        $student = Student::create($validatedData);

        // Send the unique ID to the parent's email if provided
        if (!empty($validatedData['email'])) {
            \Mail::to($validatedData['email'])->send(new \App\Mail\SendUniqueId(  $validatedData['uuid'] , $validatedData['first_name']));
        }

        return response()->json(['message' => 'Student created successfully', 'status' => 1, 'id' => $student->uuid, 'unique_id' => $uniqueQqwId], Response::HTTP_CREATED);
    }

    // Get a specific Student by id
    public function show(Student $student)
    {
        if(!$student) {
            return response()->json(['message' => 'No student with this id', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Student retrieved successfully', 'status' => 1, 'data' => $student]);
    }
    // Get a specific Student by id
 

    public function showbyid($uuid)
    {
        $student = Student::where('uuid', $uuid)->first();
        
        if(!$student) {
            return response()->json(['message' => 'Student not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Student retrieved successfully', 'status' => 1, 'data' => $student]);
    }
    public function showbyname($id)
    {
        $student = Student::latest()->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$id}%"])->get();
        
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
