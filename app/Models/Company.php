<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'comp';
    protected $fillable = [
        'invoiceId' ,'Student_name', 'Student_id', 'Email', 'Phone', 'Issue_date', 'Paymenttype', 'Amount', 'Tx_id', 'status'
    ];
}
