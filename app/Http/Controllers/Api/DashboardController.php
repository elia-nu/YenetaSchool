<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Programs;
use App\Models\Partner;
use App\Models\Student;
use App\Models\Product;
use App\Models\RegisteredStudent;
use App\Models\Gallery;
use App\Models\Event;
use App\Models\Message;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    // Get all programs
    
    public function getAllCounts()
{
    $counts = [
        'programs_count' => Programs::count(),
        'partners_count' => Partner::count(),
        'students_count' => Student::count(),
        'products_count' => Product::count(),
        'registered_students_count' => [
            'total' => RegisteredStudent::count(),
           'totalP' => RegisteredStudent::where('PaymentStatus', false)->count(),
           'male' => Student::where('gender', 'male')->count(),
           'female' => Student::where('gender', 'female')->count(),
            'enrolled' => RegisteredStudent::where('status', 'enrolled')->count(),
       //     'enrolled_by_program' => RegisteredStudent::where('status', 'enrolled')
       //                         ->with('program') // Assuming there's a 'program' relationship defined in RegisteredStudent model
       //                         ->get()
       //                         ->groupBy('program.name') // Group by program name
       //                         ->map(function ($students) {
       //                             return $students->count(); // Count students in each program
       //                         })
        ],
       // 'galleries_count' => Gallery::count(),
        'events_count' => Event::count(),
        'messages_count' => Message::count(),
        'services_count' => Service::count(),
        'staff_count' => Staff::count(),
        'orders_count' => [
            'total' => Order::count(),
            'unpaid' => Order::where('deliveryStatus', 'Unpaid')->count(),
            'Pending' => Order::where('deliveryStatus', 'Pending')->count(),
            'delivered' => Order::where('deliveryStatus', 'Delivered')->count(),
            'Onroute' => Order::where('deliveryStatus', 'Onroute')->count()
        ]

          
    ];
    $programList = Programs::all()->pluck('title', 'id');  // Changed 'name' to 'title' to list by title
    $counts['program_list'] = $programList;
    $enrolledStudentsByProgram = RegisteredStudent::where('status', 'enrolled')
                                                     ->select('course', DB::raw('count(*) as total'))  // Changed 'id' to 'program_id' assuming 'program_id' is the correct foreign key
                                                     ->groupBy('course')
                                                     ->get()
                                                     ->mapWithKeys(function ($item) use ($programList) {
                                                         if (!isset($programList[$item->course])) {  // Changed 'i' to 'program_i'
                                                             return [$item->course=> 0];  // Changed 'i' to 'program_i'
                                                         }
                                                         return [$programList[$item->course] => $item->total ?: 0];  // Changed 'id' to 'program_id'
                                                     });
    $counts['enrolled_students_by_program1'] = $enrolledStudentsByProgram;
    return response()->json(['message' => 'All counts retrieved successfully', 'status' => 1, 'data' => $counts , 'BAR' =>  $enrolledStudentsByProgram ]);
}
    
    public function index(Request $request)
    {
        $programsCount = Order::count();
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $programs = programs::offset($offset)->limit($limit)->latest()->get();
    
        $programsCount = programs::count();
        if($programs->isEmpty()) {
            return response()->json(['message' => 'No programs found', 'status' => 0, 'length' => $programsCount]);
        }
        
        return response()->json(['message' => 'Programs retrieved successfully', 'status' => 1, 'data' => $programs, 'length' => $programsCount]);
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
 
    
    // Get a specific program by id
    public function show($name)
    {
        $program = programs::where('title', 'like', '%' . $name . '%')->get();
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
