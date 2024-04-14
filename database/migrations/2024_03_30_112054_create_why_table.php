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
        Schema::create('why', function (Blueprint $table) {
            $table->id();
$table->text('Vision')->nullable();
$table->text('Vision_am')->nullable();
$table->text('mission')->nullable();
$table->text('mission_am')->nullable();
$table->text('value')->nullable();
$table->text('value_am')->nullable();
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
        Schema::dropIfExists('why');
    }
};
