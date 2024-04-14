<?php

namespace App\Listeners;

use App\Mail\WelcomeEmail;
use App\Models\RegisteredStudent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RegisteredStudent $event)
    {
        Mail::to($event->student->email)->send(new WelcomeEmail($event));
    }
}
