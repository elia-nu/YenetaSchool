<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
class sendEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $time;
    public $course;
    public $startDate;
    public $endDate;
    public $Name;

    public function __construct( $time,$course, $startDate, $endDate,$Name)
    {   $this->time = $time;
        $this->course = $course;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->Name = $Name;
 
    }

    public function build()
    {
        return $this->subject('Course Registration')
                    ->view('emails.welcome');
    }
}

