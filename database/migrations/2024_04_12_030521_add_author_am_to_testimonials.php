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
            if (!Schema::hasColumn('testimonials', 'author_am')) {
                $table->string('author_am')->nullable();
            }
            if (!Schema::hasColumn('testimonials', 'professional_am')) {
                $table->string('professional_am')->nullable();
            }
        });
    }
   
    public function down()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('author_am');
        });
    }
};
