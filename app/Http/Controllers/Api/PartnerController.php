<?php
namespace App\Http\Controllers\Api;
use App\Models\Partner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailNotification;
class PartnerController extends Controller
{

    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $messages = Partner::offset($offset)->limit($limit)->latest()->get();
        
        $messagesCount = $messages->count();
        
        if($messages->isEmpty()) {
            return response()->json(['message' => 'No Messages found', 'status' => 0, 'length' => $messagesCount]);
        }
        
        return response()->json(['message' => 'Message retrieved successfully', 'status' => 1, 'data' => $messages, 'length' => $messagesCount]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            
            'companyName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'phone' => 'required|string',
        ]);
        $validatedData['status'] = false;
        $messages = Partner::create($validatedData);
        \Mail::to($validatedData['email'])->send(new \App\Mail\SendEmailNotificationpart($validatedData['email'], $validatedData['companyName']));
      
        return response()->json(['message' => 'Message created successfully', 'status' => 1], Response::HTTP_CREATED);
    }
    // Get a specific Message by id
    public function show(Partner $messages)
    {
        return response()->json(['message' => 'Message retrieved successfully', 'status' => 1, 'data' => $messages]);
    }
    
    
    // Delete a specific Message
    public function destroy(Partner $messages)
    {
        $messages->delete();
        return response()->json(['message' => 'Message deleted successfully', 'status' => 1]);
    }


    //
}
