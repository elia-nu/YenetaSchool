<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = ['date', 'author', 'author_am', 'title', 'title_am', 'summary', 'summary_am', 'description', 'description_am', 'image'];

}
