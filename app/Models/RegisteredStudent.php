<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredStudent extends Model
{
    use HasFactory;

    protected $table = 'registeredstudent';

    protected $fillable = [
        'StudentId', 'Name', 'Course', 'Semester','Completed_date', 'PaymentStatus','Amount','Status','time'
    ];

  }
