<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
   
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $invoices = Invoice::offset($offset)->limit($limit)->latest()->get();
    
        $invoicesCount = Invoice::count();
        if($invoices->isEmpty()) {
            return response()->json(['message' => 'No invoices found', 'status' => 0, 'length' => $invoicesCount]);
        }
        
        return response()->json(['message' => 'Invoices retrieved successfully', 'status' => 1, 'data' => $invoices, 'length' => $invoicesCount]);
    }
    public function store(Request $request)
    {
        return Invoice::create($request->all());
    }

    public function show($name)
    {
        $program = Invoice::where('Student_id', $name)->get();
        
        if(!$program) {
            return response()->json(['message' => 'Program not found', 'status' => 0]);
        }
        
        return response()->json(['message' => 'Program retrieved successfully', 'status' => 1, 'data' => $program]);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());
        return $invoice;
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return 204;
    }
}
