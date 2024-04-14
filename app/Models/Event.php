<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    use HasFactory;
    protected $fillable = [
        'title', 'title_am', 'description', 'description_am', 'location', 'location_am', 'time', 'date', 'image'
    ];
}
