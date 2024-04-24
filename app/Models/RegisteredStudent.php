<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredStudent extends Model
{
    use HasFactory;

    protected $table = 'registeredstudent';

    protected $fillable = [
        'StudentId', 'Name', 'Course', 'Semester','Start_Date','End_Date', 'PaymentStatus'
    ];

  }
