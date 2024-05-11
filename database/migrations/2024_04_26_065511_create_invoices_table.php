<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceId')->unique();
            $table->string('Student_name');
            $table->string('Student_id');
            $table->string('Email');
            $table->string('Phone');
            $table->date('Issue_date');
            $table->string('Paymenttype');
            $table->decimal('Amount', 10, 2);
            $table->string('Tx_id')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
