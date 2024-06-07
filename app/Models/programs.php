<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class programs extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'title', 'title_am', 'description', 'description_am', 'price', 'teachers', 'teacher_am', 'Course', 'start_date', 'end_date', 'img_url', 'P1', 'P2'
    ];
}
