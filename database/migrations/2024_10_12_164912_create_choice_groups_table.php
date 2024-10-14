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
//        Schema::create('choice_groups', function (Blueprint $table) {
//
//            $table->id();
//            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
//            $table->string('name');
//            $table->timestamps();
//        });
        Schema::table('choice_groups', function (Blueprint $table) {
           $table->boolean('is_required')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
//    public function down()
//    {
//        Schema::dropIfExists('choice_groups');
//    }
};
