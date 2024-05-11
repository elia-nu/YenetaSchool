<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoiceId',
        'Student_name',
        'Student_id',
        'Email',
        'Phone',
        'Issue_date',
        'Paymenttype',
        'Amount',
        'Tx_id',
        'status'
    ];

}
