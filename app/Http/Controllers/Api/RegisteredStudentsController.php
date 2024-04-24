<?php

namespace App\Http\Controllers\api;
use App\Mail\sendEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\StudentEnrolled;
use App\Models\RegisteredStudent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class RegisteredStudentsController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $registeredstudent = RegisteredStudent::offset($offset)->limit($limit)->latest()->get();
       

        if($registeredstudent->isEmpty()) {
            return response()->json(['message' => 'No registeredstudent found', 'status' => 0 , 'length' => $messagesCount]);
        }

        return response()->json(['message' => 'RegisteredStudent retrieved successfully', 'status' => 1, 'data' => $registeredstudent]);
    }
    public function Unpaid()
    {
        $unpaidStudents = RegisteredStudent::where('PaymentStatus', false)->get();

        if($unpaidStudents->isEmpty()) {
            return response()->json(['message' => 'No unpaid students found', 'status' => 0, 'length' => count($unpaidStudents)]);
        }

        return response()->json(['message' => 'Unpaid students retrieved successfully', 'status' => 1, 'data' => $unpaidStudents, 'length' => count($unpaidStudents)]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'StudentId' => 'required|string|max:255',
            'Name' => 'required|string|max:255',
            'Course' => 'required|string|max:255',
            'start_date' => 'required|string',
            'end_date' => 'required|string|max:255',
            'Semester' => 'required|string|max:255',
        ]);

        $validatedData['PaymentStatus'] = false;
        $registeredStudent = RegisteredStudent::create($validatedData);
        $email = $registeredStudent -> Semester;  // Ensure this is correctly set
        Mail::to($email)->send(new sendEmail($validatedData['Course'], $validatedData['start_date'], $validatedData['end_date'],$validatedData['Name']));
        return response()->json([
            'message' => 'RegisteredStudent created successfully', 
            'status' => 1, 
            'Course' => $validatedData['Course'], 
            'start_date' => $validatedData['start_date'], 
            'Semester' => $validatedData['Semester'], 
            'end_date' => $validatedData['end_date'],
            'qq' => $qq ?? null
        ], Response::HTTP_CREATED);
    }
    // Get a specific RegisteredStudent by id
    public function show(RegisteredStudent $registeredstudent)
    {
        return response()->json(['message' => 'RegisteredStudent retrieved successfully', 'status' => 1, 'data' => $registeredstudent]);
    }

    // Get a specific RegisteredStudent by id
    public function showbyname($name)
    {
        $registeredstudent = RegisteredStudent::where('title', $name)->first();

        if(!$registeredstudent) {
            return response()->json(['message' => 'RegisteredStudent not found', 'status' => 0]);
        }

        return response()->json(['message' => 'RegisteredStudent retrieved successfully', 'status' => 1, 'data' => $registeredstudent]);
    }
    // Update a specific RegisteredStudent
    public function verify(Request $request, RegisteredStudent $registeredstudent)
    {
        $validatedData = $request->validate([
            'PaymentStatus' => 'required|boolean',
        ]);
        $registeredstudent->update(['PaymentStatus' => true]); // Set PaymentStatus to true directly
        if ($registeredstudent->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0, 'data' => $registeredstudent]);
        }
    }
    public function update(Request $request, RegisteredStudent $registeredstudent)
    {
        $validatedData = $request->validate([
            'StudentId' => 'required|string|max:255',
            'Course' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|string|max:255',
            'PaymentStatus' => 'required|boolean',
        ]);
        $registeredstudent->update($validatedData);
        if ($registeredstudent->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $registeredstudent]);
        }
    }
    // Delete a specific RegisteredStudent
    public function destroy(RegisteredStudent $registeredstudent)
    {
        $registeredstudent->delete();
        return response()->json(['message' => 'RegisteredStudent deleted successfully', 'status' => 1]);
    }



    //
}
