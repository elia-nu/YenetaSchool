<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
class SendUniqueId extends Mailable
{
    use Queueable, SerializesModels;
    public $first_name;
    public $uuid;

    public function __construct($uuid , $first_name)
    {
        $this->uuid = $uuid;
        $this->first_name = $first_name;
 
    }

    public function build()
    {
        return $this->subject('Welcome to Yeneta Language and Cultural Academy!')
                    ->view('emails.SendUniqueId');
    }
}

