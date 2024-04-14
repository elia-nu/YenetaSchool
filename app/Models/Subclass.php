<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subclass extends Model
{
    use HasFactory;

    protected $primaryKey = 'Course';
    public $incrementing = false;
    protected $fillable = [
        'Course', 'Course_am'
    ];
}
