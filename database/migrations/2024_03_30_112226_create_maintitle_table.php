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
        Schema::create('maintitle', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('name');
            $table->string('title');
            $table->string('subTitle');
            $table->string('title_am');
            $table->string('subTitle_am');
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
        Schema::dropIfExists('maintitle');
    }
};
