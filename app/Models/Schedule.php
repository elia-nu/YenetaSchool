<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'progtime';

    protected $fillable = [
        'ClassId', 'Day', 'startTime', 'endTime', 'level', 'nosit',
    ];
}
