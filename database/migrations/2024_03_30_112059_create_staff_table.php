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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_am')->nullable();
            $table->string('position')->nullable();
            $table->string('position_am')->nullable();
            $table->string('social_link')->nullable();
            $table->text('details')->nullable();
            $table->text('details_am')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('subtitle_am')->nullable();
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
        Schema::dropIfExists('staff');
    }
};
