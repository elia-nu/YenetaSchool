<?php

namespace App\Http\Controllers\api;
use App\Mail\sendEmail;
use App\Mail\StudentUpdateNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\StudentEnrolled;
use App\Models\RegisteredStudent;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class RegisteredStudentsController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $registeredstudent = RegisteredStudent::offset($offset)->limit($limit)->latest()->get();
        $studentsCount = RegisteredStudent::count();

        if($registeredstudent->isEmpty()) {
            return response()->json(['message' => 'No registered students found', 'status' => 0, 'length' => $studentsCount]);
        }

        return response()->json(['message' => 'Registered students retrieved successfully', 'status' => 1, 'data' => $registeredstudent, 'length' => $studentsCount]);
    }

    public function Chart(Request $request)
    {
        $currentDate = now()->toDateString();
        
        $enrolledStudentsByCourse = RegisteredStudent::where('Status', 'enrolled')
                                                     ->select('Course', DB::raw('count(*) as total'))
                                                     ->groupBy('Course')
                                                     ->get();

        return response()->json([
            'status' => 1,
            'date' => $currentDate,
            'enrolled_students_by_course' => $enrolledStudentsByCourse
        ]);
    }  

    public function index1(Request $request)
    {
        $currentDate = now()->toDateString();
        
        $activeStudents = RegisteredStudent::where('Status', 'enrolled')
                                           ->count();

        $inactiveStudents = RegisteredStudent::where('Status', '!=', 'enrolled')
                                                ->count();

        return response()->json([
            'status' => 1,
            'active_students' => $activeStudents, 
            'inactive_students' => $inactiveStudents
        ]);
    }
    public function index2(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $activeStudents = RegisteredStudent::where('Status', 'enrolled')
                                           ->offset($offset)
                                           ->limit($limit)
                                           ->latest()->get();
        $activeStudentsCount = RegisteredStudent::where('Status', 'enrolled')->count();
        $studentsCount = RegisteredStudent::count();

        if($activeStudents->isEmpty()) {
            return response()->json(['message' => 'No active students found', 'status' => 0, 'length' => $activeStudentsCount]);
        }

        return response()->json(['message' => 'Active students retrieved successfully', 'status' => 1, 'data' => $activeStudents, 'length' => $activeStudentsCount , 'length1' => $studentsCount]);
    }

    public function Unpaid(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        $unpaidStudents = RegisteredStudent::where('PaymentStatus', false)
                                           ->offset($offset)
                                           ->limit($limit)
                                           ->get();

        $totalUnpaid = RegisteredStudent::where('PaymentStatus', false)->count();

        if($unpaidStudents->isEmpty()) {
            return response()->json(['message' => 'No unpaid students found', 'status' => 0, 'length' => $totalUnpaid]);
        }

        return response()->json(['message' => 'Unpaid students retrieved successfully', 'status' => 1, 'data' => $unpaidStudents, 'length' => $totalUnpaid]);
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
            'time' => 'required|string|max:255',
        ]);

        $validatedData['Status'] = 'enrolled';
        $validatedData['PaymentStatus'] = false;
        $registeredStudent = RegisteredStudent::create($validatedData);


        $email = $registeredStudent->Semester;  // Ensure this is correctly set
        Mail::to($email)->send(new sendEmail($validatedData['time'], $validatedData['Course'], $validatedData['start_date'], $validatedData['end_date'], $validatedData['Name']));

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
    public function searchByName($name)
    {
        $registeredstudent = RegisteredStudent::where('name', $name)->first();

        if(!$registeredstudent) {
            return response()->json(['message' => 'RegisteredStudent not found', 'status' => 0]);
        }

        return response()->json(['message' => 'RegisteredStudent retrieved successfully', 'status' => 1, 'data' => $registeredstudent]);
    }
    
    public function verify(Request $request, RegisteredStudent $program)
    {
        try {
            $validatedData = $request->validate([
                'StudentId' => 'required|string|max:255',
                'Course' => 'required|string|max:255',
                'start_date' => 'required',
                'end_date' => 'required|string|max:255',
 
                'PaymentStatus' => 'required|boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        $program->update($validatedData);
        if ($program->wasChanged()) {
            // Send email with Student ID and Course
            Mail::to($program->Semester)->send(new StudentUpdateNotification($validatedData['Course'], $program->Name, $program->StudentId));
            return response()->json(['message' => 'Successfully updated and email sent', 'status' => 1]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0, 'data' => $program]);
        }
    }

    public function verify2(Request $request, RegisteredStudent $program)
    {
        try {
            $validatedData = $request->validate([
               
                'Completed_date' => 'required|string|max:255',
                'Status' => 'required|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        // Handle the image upload
       
    
    
        $program->update($validatedData);
        if ($program->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $program]);
        }
    }
    // Update a specific RegisteredStudent
    public function verify1(Request $request, RegisteredStudent $registeredstudent)
    {
        $validatedData = $request->validate([
       
         
        ]);
        $validatedData['PaymentStatusl'] = '1'; // Removes 'public/' from the path
      
       $registeredstudent->update(['PaymentStatus' => "1"]); // Set PaymentStatus to true directly
      $registeredstudent->update($validatedData);
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
            'start_date' => 'required',
            'end_date' => 'required|string|max:255',
            'PaymentStatus' => 'required|boolean',
        ]);

        // Log the received data
        \Log::info('Update RegisteredStudent:', $validatedData);

        $registeredstudent->update($validatedData);

        if ($registeredstudent->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1, 'data' => $registeredstudent]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0, 'data' => $registeredstudent]);
        }
    }
    // Delete a specific RegisteredStudent
    public function destroy(RegisteredStudent $registeredstudent)
    {
        $registeredstudent->delete();
        return response()->json(['message' => 'RegisteredStudent deleted successfully', 'status' => 1]);
    }

    public function searchById($id)
    {
        $student = RegisteredStudent::where('StudentId', $id)->get();
        
        if(!$student) {
            return response()->json(['message' => 'Student not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Student retrieved successfully', 'status' => 1, 'data' => $student]);
    }
    public function searchById1($id)
    {
        $student = RegisteredStudent::where('StudentId', $id)->latest()->where('PaymentStatus', 0)->get();
        if(!$student) {
            return response()->json(['message' => 'Student not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Student retrieved successfully', 'status' => 1, 'data' => $student]);
    }
    

    //
}

