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
    public $course;
    public $startDate;
    public $endDate;
    public $Name;

    public function __construct($course, $startDate, $endDate,$Name)
    {
        $this->course = $course;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->Name = $Name;
 
    }

    public function build()
    {
        return $this->subject('Welcome to Our Application!')
                    ->view('emails.welcome');
    }
}

