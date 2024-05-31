<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $orderNo;
    public $price;
    public $date;
    public $name;
    public $formattedName;

    /**
     * Function to reformat the product name string into a readable format with quantities.
     * 
     * @param string $name Comma-separated product names with quantities.
     * @return string Formatted product names with quantities.
     */
    public function formatProductName($name) {
        // Replace '/n' with '<br/>' for HTML display
        $formatted = str_replace("/n", "<br/>  ", $name);
        
        // Optional: format further if needed, e.g., adding "Qty: " or wrapping in <strong>


        return $formatted;
    }

    /**
     * Constructor to initialize the mail object with necessary data.
     * 
     * @param string $firstName
     * @param string $orderNo
     * @param float $price
     * @param string $date
     * @param string $name
     */
    public function __construct($firstName, $orderNo, $price, $date, $name)
    {
        $this->firstName = $firstName;
        $this->orderNo = $orderNo;
        $this->price = $price;
        $this->date = $date;
        $this->name = $name;
        $this->formattedName = $this->formatProductName($name);
    }

    public function build()
    {
        return $this->subject(' Your Order Confirmation and Shipment Update')
                    ->view('emails.OrderConfirmationMail')
                    ->with([
                        'firstName' => $this->firstName,
                        'orderNo' => $this->orderNo,
                        'price' => $this->price,
                        'date' => $this->date,
                        'formattedName' => $this->formattedName
                    ]);
    }
}

