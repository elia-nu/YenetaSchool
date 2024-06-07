<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
class sendEmail1 extends Mailable
{
    use Queueable, SerializesModels;
    public $sublink;
    public $course;
    public $Name;

    public function __construct( $sublink,$course ,$Name)
    {   $this->time = $sublink;
        $this->course = $course;
        $this->Name = $Name;
 
    }

    public function build()
    {
        return $this->subject('Payment link for this ' . $this->course . ' for student ' . $this->Name)
                    ->view('emails.welcome1');
    }
}

