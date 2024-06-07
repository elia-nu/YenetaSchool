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
   
    public function createSubscriptionSession(Request $request)
    {
        Stripe::setApiKey('sk_test_51OuCcs2K6GfB3dVvZTwLKX7dKhchQxG9EWGQMu1XxtSp9sTYd7LkV7jZtyFWUVKt4u8zTqUXyd90hk3s5zUkq7u2009r67q3ZL');

        // Validate request data first
        $validated = $request->validate([
            'product_name' => 'required|string', // Assume a predefined Stripe price ID for subscription
            'success_url' => 'required|url',
            'cancel_url' => 'required|url',
            'student_id' => 'required|string',
            'email' => 'required|email'
        ]);

        // Creating the subscription session with validated data
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $validated['product_name'], // Referencing the price ID directly
                'quantity' => 1,
            ]],
            'mode' => 'subscription', // Set mode to 'subscription'
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

    public function createSubscriptionSession1(Request $request)
{
    Stripe::setApiKey('sk_test_51OuCcs2K6GfB3dVvZTwLKX7dKhchQxG9EWGQMu1XxtSp9sTYd7LkV7jZtyFWUVKt4u8zTqUXyd90hk3s5zUkq7u2009r67q3ZL');

    // Validate request data first
    $validated = $request->validate([
        'product_name' => 'required|string', // Assume a predefined Stripe price ID for subscription
        'success_url' => 'required|url',
        'cancel_url' => 'required|url',
        'student_id' => 'required|string',
        'email' => 'required|email',
        'end_date' => 'required|date',
        'start_date' => 'required|date' // Add end date to the validation rules
    ]);

    // Function to get the next 15th of the month timestamp
    

    // Calculate the end date timestamp
    $endDate = new \DateTime($validated['end_date']);
    $endDateTimestamp = $endDate->getTimestamp();
    $startDate = new \DateTime($validated['start_date']);
    $startDateTimestamp = $startDate->getTimestamp();

    // Create the subscription
  

    // Create the session

    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price' => $validated['product_name'],
            'quantity' => 1,
        ]],

        
        'mode' => 'subscription',
        'success_url' => $validated['success_url'] . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $validated['cancel_url'],
        'customer_email' => $validated['email'], // This will create a customer with this email
        'subscription_data' => [
            'billing_cycle_anchor' => $startDateTimestamp,
        //    'cancel_at' => $endDateTimestamp,
            'metadata' => [
                'student_id' => $validated['student_id'],
                'custom_metadata_key' => 'custom_metadata_value',
                'user_name' => 'John Doe', // Added user name as per instructions
            ]
        ],
    ]);
    \Log::info('Stripe Session Details:', ['session' => $session->toArray()]);

    // Sending URL via email
    \Mail::to($validated['email'])->send(new \App\Mail\SendUrlMail($session->url));

    return response()->json(['id' => $session->url]);
}

public function handleSuccessPage(Request $request)
{
    \Stripe\Stripe::setApiKey('sk_test_51OuCcs2K6GfB3dVvZTwLKX7dKhchQxG9EWGQMu1XxtSp9sTYd7LkV7jZtyFWUVKt4u8zTqUXyd90hk3s5zUkq7u2009r67q3ZL');

    $sessionId = $request->query('session_id');

    if (!$sessionId) {
        return response()->json(['error' => 'Missing session_id'], 400);
    }

    $session = \Stripe\Checkout\Session::retrieve($sessionId);

    // Retrieve the subscription ID from the session
    $subscriptionId = $session->subscription;

    // Retrieve the end date from the session metadata
    $endDate = $session->metadata->end_date;
    $endDateTimestamp = (new \DateTime($endDate))->getTimestamp();

    // Update the subscription to set the cancel_at parameter
    \Stripe\Subscription::update(
        $subscriptionId,
        ['cancel_at' => $endDateTimestamp]
    );

    return response()->json(['status' => 'success']);
}


}




    
