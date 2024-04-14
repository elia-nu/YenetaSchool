<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'gallery';
    protected $fillable = [
        'img_url', 'title', 'description', 'description_am', 'group_name', 'group_name_am', 'category', 'category_am'
    ];
}
