<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'dob', 'parent_name', 'parent_email', 'mobile_number', 'fixed_number', 'course', 'address', 'emergency_contact', 'emergency_contact_number'
    ];
}
