<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    
    protected $table = 'about_us';
    
    protected $fillable = [
        'name',
        'title',
        'title_am',
        'sub_title',
        'sub_title_am',
        'description',
        'description_am',
        'link',
        'img_url',
    ];
}

