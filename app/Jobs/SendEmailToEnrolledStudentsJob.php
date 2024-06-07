<?php

namespace App\Jobs;

use App\Mail\sendEmail1;
use App\Models\RegisteredStudent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToEnrolledStudentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $enrolledStudents = RegisteredStudent::where('Status', 'enrolled1')->get();
        foreach ($enrolledStudents as $student) {
            if (filter_var($student->Semester, FILTER_VALIDATE_EMAIL)) {
                Mail::to($student->Semester)->send(new sendEmail1(
                    $student->sublink, 
                    $student->Course, 
                    $student->Name
                ));
            }
        }
    }
}