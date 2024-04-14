<?php

namespace App\Http\Controllers\api;
use App\Models\MainTitle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class MainTitleController extends Controller
{
    
    public function index()
    {
        $maintitle = MainTitle::all();
        
        if($maintitle->isEmpty()) {
            return response()->json(['message' => 'No programs found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Programs retrieved successfully', 'status' => 1, 'data' => $maintitle]);
    }

    public function update(Request $request, MainTitle $maintitle)
    {
      
    
        $aboutus->update($validatedData);
        if ($aboutus->wasChanged()) {
            return response()->json(['message' => 'Successfully updated', 'status' => 1]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0, 'data' => $maintitle]);
        }
    }


    //
}
