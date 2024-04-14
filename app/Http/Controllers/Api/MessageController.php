<?php

namespace App\Http\Controllers\Api;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class MessageController extends Controller
{

    public function index()
    {
        $messages = Message::all();
        
        $messagesCount = $messages->count();
        
        if($messages->isEmpty()) {
            return response()->json(['message' => 'No Messages found', 'status' => 0, 'length' => $messagesCount]);
        }
        
        return response()->json(['message' => 'Message retrieved successfully', 'status' => 1, 'data' => $messages, 'length' => $messagesCount]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'contact' => 'sometimes|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
    
        $messages = Message::create($validatedData);
        return response()->json(['message' => 'Message created successfully', 'status' => 1], Response::HTTP_CREATED);
    }
    // Get a specific Message by id
    public function show(Message $messages)
    {
        return response()->json(['message' => 'Message retrieved successfully', 'status' => 1, 'data' => $messages]);
    }
    
    // Get a specific Message by id
    public function showbyname($name)
    {
        $messages = Message::where('title', $name)->first();
        
        if(!$messages) {
            return response()->json(['message' => 'Message not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Message retrieved successfully', 'status' => 1, 'data' => $messages]);
    }
    // Update a specific Message
    public function update(Request $request, Message $messages)
    {
        $validatedData = $request->validate([
            'contact' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
        $messages->update($validatedData);
        if ($messages->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $messages]);
        }
    }
    // Delete a specific Message
    public function destroy(Message $messages)
    {
        $messages->delete();
        return response()->json(['message' => 'Message deleted successfully', 'status' => 1]);
    }


    //
}
