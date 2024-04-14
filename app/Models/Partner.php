<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{protected $table = 'Partner';
    use HasFactory;
protected $fillable = [
    'email',
    'companyName',
    'status',
    'message',
    'phone',
];
}
