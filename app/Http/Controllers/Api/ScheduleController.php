<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
   
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $invoices = Schedule::offset($offset)->limit($limit)->latest()->get();
    
        $invoicesCount = Schedule::count();
        if($invoices->isEmpty()) {
            return response()->json(['message' => 'No invoices found', 'status' => 0, 'length' => $invoicesCount]);
        }
        
        return response()->json(['message' => 'Invoices retrieved successfully', 'status' => 1, 'data' => $invoices, 'length' => $invoicesCount]);
    }
    public function store(Request $request)
    {
        Log::info('Store method called', ['request' => $request->all()]);

        $invoiceData = $request->all();
        $createdInvoice = Schedule::create($invoiceData);

        Log::info('Invoice created', ['invoice' => $createdInvoice]);

        return response()->json(['message' => 'Invoice created successfully', 'data' => $createdInvoice], 201);
    }

    public function show($name)
    {
        $program = Schedule::where('ClassId', $name)->get();
        
        if(!$program) {
            return response()->json(['message' => 'Program not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Program retrieved successfully', 'status' => 1, 'data' => $program]);
    }

    public function update(Request $request, $id)
    {
        $invoice = Schedule::findOrFail($id);
        $invoice->update($request->all());
        return $invoice;
    }

    public function destroy($id)
    {
        $invoice = Schedule::findOrFail($id);
        $invoice->delete();
        return 204;
    }
    public function decrementAmount(Request $request, $id)
{
    // Step 1: Find the Schedule by ID
    $schedule = Schedule::findOrFail($id);

    // Step 2: Get the amount to decrement from the request, default is 1
    $amountToDecrement = $request->input('amount', 1);

    // Step 3: Check if the current 'nosit' is greater than zero
    if ($schedule->nosit > 0) {
        // Step 4: Decrement the 'nosit' value
        $schedule->nosit -= $amountToDecrement;

        // Step 5: Save the updated Schedule
        $schedule->save();

        // Step 6: Return a success response with the updated Schedule data
        return response()->json(['message' => 'Amount decremented successfully', 'status' => 1, 'data' => $schedule]);
    } else {
        // Step 7: Return a success response indicating no decrement was needed
        return response()->json(['message' => 'No decrement needed', 'status' => 1, 'data' => $schedule]);
    }
}

}

