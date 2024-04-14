<?php

namespace App\Http\Controllers\api;
use App\Models\AboutUs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AboutusController extends Controller
{

    public function index()
    {
        $aboutus = AboutUs::all();
        
        if($aboutus->isEmpty()) {
            return response()->json(['message' => 'No programs found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Programs retrieved successfully', 'status' => 1, 'data' => $aboutus]);
    }

    public function update(Request $request, AboutUs $aboutus)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'title_am' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'sub_title_am' => 'required|string|max:255',
            'description' => 'required|string',
            'description_am' => 'required|string',
            'link' => 'nullable|url',
            'img_url' => 'required|url',
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
