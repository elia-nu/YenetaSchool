<?php

namespace App\Http\Controllers\api;
use App\Models\Why;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class WhyController extends Controller
{


    public function index()
    {
        $programs = Why::all();
        
        if($programs->isEmpty()) {
            return response()->json(['message' => 'No programs found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Programs retrieved successfully', 'status' => 1, 'data' => $programs]);
    }

    public function update(Request $request, Why $aboutus)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
         
        ]);
    
        $aboutus->update($validatedData);
        if ($aboutus->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0, 'data' => $aboutus]);
        }
    }
    //
}
