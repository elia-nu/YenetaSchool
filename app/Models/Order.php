<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
 protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address1', 'address2',
        'city', 'state', 'zipcode', 'deliveryStatus', 'orderNo', 'name', 'price'
    ];


}
