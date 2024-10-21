<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('ratings', function (Blueprint $table) {
             $table->id();
             $table->string('feedback');
             $table->integer('stars');
             $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
             $table->foreignId('order_id')->nullable()->references('id')->on('orders')->onDelete('cascade');
             $table->foreignId('restaurant_id')->nullable()->references('id')->on('restaurants')->onDelete('cascade');
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
         Schema::dropIfExists('ratings');
     }
};
