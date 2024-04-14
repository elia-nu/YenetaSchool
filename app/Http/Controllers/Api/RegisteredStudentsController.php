<?php

namespace App\Http\Controllers\api;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\StudentEnrolled;
use App\Models\RegisteredStudent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class RegisteredStudentsController extends Controller
{

    public function index()
    {
        $registeredstudent = RegisteredStudent::all();

        if($registeredstudent->isEmpty()) {
            return response()->json(['message' => 'No registeredstudent found', 'status' => 0]);
        }

        return response()->json(['message' => 'RegisteredStudent retrieved successfully', 'status' => 1, 'data' => $registeredstudent]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'StudentId' => 'required|string|max:255',
            'Course' => 'required|string|max:255',
            'start_date' => 'required|string',
            'end_date' => 'required|string|max:255',

        ]);
        $validatedData['PaymentStatus'] = false;
        $registeredstudent = RegisteredStudent::create($validatedData);
        if($registeredstudent) {
            event(new StudentEnrolled($registeredstudent));
        }
        return response()->json(['message' => 'RegisteredStudent created successfully', 'status' => 1], Response::HTTP_CREATED);
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
