<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey('sk_test_51OuCcs2K6GfB3dVvZTwLKX7dKhchQxG9EWGQMu1XxtSp9sTYd7LkV7jZtyFWUVKt4u8zTqUXyd90hk3s5zUkq7u2009r67q3ZL');


    

        // Validate request data first
        $validated = $request->validate([
            'product_name' => 'required|string',
            'amount' => 'required|numeric',
            'success_url' => 'required|url',
            'cancel_url' => 'required|url',
            'student_id' => 'required|string',  // Make sure this is passed correctly
            'email' => 'required|email'
            
        ]);
    
        // Creating the session with validated data
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $validated['product_name'],
                    ],
                    'unit_amount' => $validated['amount'],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $validated['success_url'],
            'cancel_url' => $validated['cancel_url'],
            'metadata' => [
                'student_id' => $validated['student_id'], 
                'custom_metadata_key' => 'custom_metadata_value', // Ensure this value is meaningful or properly passed
            ]
        ]);
        \Log::info('Stripe Session Details:', ['session' => $session->toArray()]);

        // Sending URL via email
        \Mail::to($validated['email'])->send(new \App\Mail\SendUrlMail($session->url));
    
        return response()->json(['id' => $session->url]);
    }
    
    }


