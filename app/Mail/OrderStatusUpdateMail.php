<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $lastName;
    public $status;
    public $date;
    public $orderName;
    public $orderNo;
    public $formattedName;

      /**
     * Function to reformat the product name string into a readable format with quantities.
     * 
     * @param string $name Comma-separated product names with quantities.
     * @return string Formatted product names with quantities.
     */
    public function formatProductName($orderName) {
        // Replace '/n' with '<br/>' for HTML display
        $formatted = str_replace("/n", "<br/>  ", $orderName);
        
        // Optional: format further if needed, e.g., adding "Qty: " or wrapping in <strong>


        return $formatted;
    }



    public function __construct($firstName, $lastName, $status, $date , $orderNo, $orderName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->status = $status;
        $this->date = $date;
        $this->orderName = $orderName;
        $this->orderNo = $orderNo;
        $this->formattedName = $this->formatProductName($orderName);

    }

    public function build()
    {
        return $this->view('emails.order_status_update')
                    ->subject('Order Status Update')
                    ->with([
                        'firstName' => $this->firstName,
                        'lastName' => $this->lastName,
                        'status' => $this->status,
                        'date' => $this->date,
                        'orderName' => $this->orderName,
                        'orderNo' => $this->orderNo,
                    ]);
    }
}