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
        Schema::create('comp', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
$table->string('title_am')->nullable();
$table->string('subtitle')->nullable();
$table->string('subtitle_am')->nullable();
$table->string('class_name')->nullable();
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
        Schema::dropIfExists('comp');
    }
};
