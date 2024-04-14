<?php

namespace App\Http\Controllers\api;
use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class ServicesController extends Controller
{

    public function index()
    {
        $services = Service::all();
        
        if($services->isEmpty()) {
            return response()->json(['message' => 'No Services found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Service retrieved successfully3', 'status' => 1, 'data' => $services]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'title_am' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'description' => 'required|string',
            'description_am' => 'required|string',
            'link' => 'nullable|String'
        ]);
        if ($validatedData['message'] ?? false) {
            return response()->json(['message' => 'Message received'], Response::HTTP_OK);
        }

        $services = Service::create($validatedData);
        return response()->json(['message' => 'Service created successfully', 'status' => 1], Response::HTTP_CREATED);
    }

    // Get a specific Service by id
    public function show(Service $services)
    {
        return response()->json(['message' => 'Service retrieved successfully', 'status' => 1, 'data' => $services]);
    }
    
    // Get a specific Service by id
    public function showbyname($name)
    {
        $services = Service::where('title', $name)->first();
        
        if(!$services) {
            return response()->json(['message' => 'Service not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Service retrieved successfully', 'status' => 1, 'data' => $services]);
    }
    // Update a specific Service
   
    public function update(Request $request, Service $program)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'title_am' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'description' => 'required|string',
            'description_am' => 'required|string',
            'link' => 'nullable|string'
        ]);

        $program->update($validatedData);
        if ($program->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $program]);
        }
    }
    // Delete a specific program
    public function destroy(Service $program)
    {
        $program->delete();
        return response()->json(['message' => 'Program deleted successfully', 'status' => 1]);
    }

    //
}
