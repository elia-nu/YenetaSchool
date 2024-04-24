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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
$table->string('title_am')->nullable();
$table->text('description')->nullable();
$table->text('description_am')->nullable();
$table->decimal('price', 10, 2)->nullable();
$table->string('teachers')->nullable();
$table->string('teacher_am')->nullable();
$table->string('Course')->nullable();
$table->string('start_date')->nullable();
$table->string('end_date')->nullable();
$table->string('img_url')->nullable();
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
        Schema::dropIfExists('classes');
    }
};
