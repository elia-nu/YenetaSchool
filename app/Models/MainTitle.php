<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainTitle extends Model
{
    use HasFactory;

    protected $table = 'maintitle';
    protected $fillable = [
        'name', 'title', 'subTitle', 'title_am', 'subTitle_am'
    ];
}
