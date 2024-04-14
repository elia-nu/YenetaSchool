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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('author');
            $table->string('author_am');
            $table->string('title');
            $table->string('title_am')->nullable();
            $table->text('summary')->nullable();
            $table->text('summary_am')->nullable();
            $table->text('description')->nullable();
            $table->text('description_am')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('blogs');
    }
};
