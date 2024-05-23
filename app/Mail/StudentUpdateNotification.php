<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentUpdateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $course;
   public $name;
   public $uuid;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course , $name , $uuid)
    {
        $this-> course = $course;
        $this->name = $name;
        $this->uuid = $uuid;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.StudentUpdateNotification')
                    ->subject('Payment Confirmation');
    }
}