<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_am', 'position', 'position_am', 'social_link', 'details', 'details_am', 'subtitle', 'subtitle_am', 'image'
    ];
}
