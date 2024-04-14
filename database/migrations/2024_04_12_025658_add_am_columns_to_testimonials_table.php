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
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('author_am')->nullable(); // Assuming you want this to be nullable
            $table->string('professional_am')->nullable(); // Assuming this is also missing and needed
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
   

    public function down()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('author_am');
            $table->dropColumn('professional_am');
        });
    }
};
