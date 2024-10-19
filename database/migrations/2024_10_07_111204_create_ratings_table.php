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
             $table->unsignedBigInteger('order_id');
             $table->unsignedBigInteger('user_id');
             $table->string('feedback');
             $table->integer('stars');
             $table->foreign('user_id')->references('id')->on('users');
             $table->foreign('order_id')->references('id')->on('orders');
             $table->unsignedBigInteger('restaurant_id')->nullable()->after('id');
             $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
             $table->timestamps();

         });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::table('ratings', function (Blueprint $table) {
    //         $table->dropForeign(['restaurant_id']);
    //         $table->dropColumn('restaurant_id');
    //     });

    //     Schema::dropIfExists('ratings');
    // }
};
