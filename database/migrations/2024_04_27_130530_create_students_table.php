<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->unique();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->nullable();
                $table->date('dob')->nullable(); // Date of Birth
                $table->string('parent_name')->nullable();
                $table->string('parent_email')->nullable();
                $table->string('mobile_number')->nullable();

                $table->string('gender')->nullable();
                $table->text('address')->nullable();
                $table->string('emergency_contact')->nullable();
                $table->string('emergency_contact_number')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};