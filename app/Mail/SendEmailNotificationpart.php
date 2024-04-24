<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailNotificationpart extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $companyName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($companyName , $email)
    {
        $this->email = $email;
        $this->companyName = $companyName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sendNotificationpart')
                    ->subject('New Message Created');
    }
}