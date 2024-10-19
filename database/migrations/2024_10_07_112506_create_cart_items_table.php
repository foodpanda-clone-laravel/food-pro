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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreignId('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');
            $table->integer('quantity');
            $table->float('price');
            $table->foreignId('choice_id')->nullable()->references('id')->on('choices');
            $table->foreignId('choice_group_id')->nullable()->references('id')->on('choice_groups');
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
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
        Schema::dropIfExists('cart_items');
    }
};
