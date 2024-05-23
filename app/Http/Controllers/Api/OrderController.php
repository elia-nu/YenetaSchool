<?php


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $programs = Order::offset($offset)->limit($limit)->latest()->get();
    
        $programsCount = Order::count();
        if($programs->isEmpty()) {
            return response()->json(['message' => 'No Order found', 'status' => 0, 'length' => $programsCount]);
        }
        
        return response()->json(['message' => 'Order retrieved successfully', 'status' => 1, 'data' => $programs, 'length' => $programsCount]);
    }


    public function index1(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $deliveryStatus = $request->input('deliveryStatus');
        
        $programs = Order::when($deliveryStatus, function ($query) use ($deliveryStatus) {
            return $query->where('deliveryStatus', $deliveryStatus);
        })->when(!$deliveryStatus, function ($query) {
            return $query;
        })->offset($offset)->limit($limit)->latest()->get();
    
        $programsCount = Order::where('deliveryStatus', $deliveryStatus)->count();
        if($programs->isEmpty()) {
            return response()->json(['message' => 'No Order found', 'status' => 0, 'length' => $programsCount]);
        }
        
        return response()->json(['message' => 'Order retrieved successfully', 'status' => 1, 'data' => $programs, 'length' => $programsCount]);
    }
    public function store(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address1' => 'required|string|max:255',
        'address2' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zipcode' => 'required|string|max:10',
        'name' => 'required|string',
        'price' => 'required|numeric',
    ]);
    $validatedData['deliveryStatus'] = 'Unpaid';
    // Generate a unique order number prefixed with 'ORD'
    do {
        $orderNo = 'ORD' . strtoupper(dechex(rand(1000000000, 2147483647)));
    } while (Order::where('orderNo', $orderNo)->exists());

    $validatedData['orderNo'] = $orderNo;

    // Handle image upload if provided
    if ($request->hasFile('img')) {
        $image = $request->file('img');
        $path = $image->store('public/images');
        $validatedData['image'] = 'storage/' . substr($path, 7); 
    }

    // Create the order record
    $order = Order::create($validatedData);


    // Send email with order details
    $date = now()->toDateString();
    \Mail::to($validatedData['email'])->send(new \App\Mail\OrderConfirmationMail($validatedData['first_name'], $validatedData['orderNo'], $validatedData['price'], $date ,$validatedData['name']));
    // Return a successful response
    return response()->json(['status' => 1, 'message' => 'Order created successfully',  'order' => $order], Response::HTTP_CREATED);
}

    public function show($id)
    {
        return Order::find($id);
    }

  
    public function update(Request $request, Order $program)
    {
        try {
            $validatedData = $request->validate([
                'deliveryStatus' => 'required|string|max:50',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        // Handle the image upload
        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['image'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }
    
        $program->update($validatedData);

        if ($program->wasChanged()) {
            // Send email if the delivery status is 'Onroute' or 'Delivered'
            if (in_array($validatedData['deliveryStatus'], ['OnRoute', 'Delivered'])) {
                $date = now()->toDateString();
                \Mail::to($program->email)->send(new \App\Mail\OrderStatusUpdateMail(
                    $program->first_name,
                    $program->last_name,
                    $validatedData['deliveryStatus'],
                    $date,
                    $program->orderNo,
                    $program->name
                ));
            }

            return response()->json(['message' => 'Successfully updated', 'status' => 1, 'data' => $program]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0, 'data' => $program]);
        }
    }
    public function destroy($id)
    {
        Order::destroy($id);
        return response()->json(['message' => 'Order deleted successfully', 'status' => 1], 200);
    }

    
    public function search($name)
    {
        $program = Order::where('orderNo', $name)->get();
        
        if(!$program) {
            return response()->json(['message' => 'Program not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Program retrieved successfully', 'status' => 1, 'data' => $program]);
    }
}
