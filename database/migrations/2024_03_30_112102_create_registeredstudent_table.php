<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registeredstudent', function (Blueprint $table) {
            $table->id('SalesId');
            $table->unsignedBigInteger('StudentId');
            $table->string('Name');
            $table->string('Course');
            $table->integer('Semester');
            $table->string('PaymentStatus', 100);

   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registeredstudent');
    }
};
