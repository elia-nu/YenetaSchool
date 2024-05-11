<?php


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $programs = Product::offset($offset)->limit($limit)->latest()->get();
    
        $programsCount = Product::count();
        if($programs->isEmpty()) {
            return response()->json(['message' => 'No Product found', 'status' => 0, 'length' => $programsCount]);
        }
        
        return response()->json(['message' => 'Product retrieved successfully', 'status' => 1, 'data' => $programs, 'length' => $programsCount]);
    }

    public function store(Request $request)
    {     try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'video' => 'required|string|max:255',
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

        // Assuming other fields are directly assignable
        $program = Product::create($validatedData);

        return response()->json(['message' => 'Product created successfully', 'status' => 1], Response::HTTP_CREATED);
    }

    public function show1($id)
    {
        return Product::find($id);
    }

  
    public function update(Request $request, Product $program)
    {
        try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'video' => 'required|string|max:255',
     
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
            return response()->json(['message' => 'Successfully updated', 'status' => 1. ]);
        } else {
            return response()->json(['message' => 'No changes made', 'status' => 0 , 'data' => $program]);
        }
    }
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json(['message' => 'Product deleted successfully', 'status' => 1], 200);
    }

    
    public function show($name)
    {
        $program = Product::where('name', $name)->get();
        
        if(!$program) {
            return response()->json(['message' => 'Product not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Product retrieved successfully', 'status' => 1, 'data' => $program]);
    }
}
