<?php

namespace App\Http\Controllers\Api;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class EventsController extends Controller
{

    public function index()
    {
        $events = Event::all();
        
        if($events->isEmpty()) {
            return response()->json(['message' => 'No events found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Event retrieved successfully', 'status' => 1, 'data' => $events]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'title_am' => 'sometimes|string|max:255',
            'description' => 'required|string',
            'description_am' => 'sometimes|string',
            'location' => 'required|string',
            'location_am' => 'sometimes|string',
            'time' => 'required|date_format:H:i', // Adjust the format as needed
            'date' => 'required|date',
            // Assuming you want to validate an uploaded image file
        ]);


        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['image'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }

        if ($validatedData['message'] ?? false) {
            return response()->json(['message' => 'Message received'], Response::HTTP_OK);
        }

    
        $event = Event::create($validatedData);
        return response()->json(['message' => 'Program created successfully', 'status' => 1], Response::HTTP_CREATED);

    }

    // Get a specific event by id
    public function show(Event $program)
    {
        return response()->json(['message' => 'Program retrieved successfully', 'status' => 1, 'data' => $program]);
    }
    
    
    // Get a specific event by id
    public function showbyname($name)
    {
        $event = Event::where('title', $name)->first();
        
        if(!$event) {
            return response()->json(['message' => 'event not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'event retrieved successfully', 'status' => 1, 'data' => $event]);
    }
    // Update a specific event

    public function update(Request $request, Event $program)
    {
      
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'title_am' => 'sometimes|string|max:255',
            'description' => 'required|string',
            'description_am' => 'sometimes|string',
            'location' => 'required|string',
            'location_am' => 'sometimes|string',
            'time' => 'required', // Adjust the format as needed
            'date' => 'required|date',
                    ]);
        if ($request->hasFile('img')) {
            $image = $request->file('img'); // Assuming single file upload for simplicity
            $path = $image->store('public/images');
            $validatedData['image'] = 'storage/' . substr($path, 7); // Removes 'public/' from the path
        }

        $program->update($validatedData);
        if ($program->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $program]);
        }
    }

    // Delete a specific event
    public function destroy(Event $program)
    {
        $program->delete();
        return response()->json(['message' => 'Program deleted successfully', 'status' => 1]);
    }

}