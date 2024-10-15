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
//        Schema::create('cart_items', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('session_id');
//            $table->unsignedBigInteger('menu_item_id');
//            $table->integer('quantity');
//            $table->json('selected_variations')->nullable()->default(null);
//            $table->json('selected_addons')->nullable()->default(null);
//            $table->timestamps();
//        });
//        Schema::table('cart_items', function (Blueprint $table) {
//            $table->float('price');
//        });
//        Schema::table('cart_items', function (Blueprint $table) {
//            $table->foreignId('choice_id')->nullable()->default(null)->references('id')->on('choices');
//            // if the user wants to edit the variation he weill get the choice group from this column
//            $table->foreignId('choice_group_id')->nullable()->default(null)->references('id')->on('choice_groups');
//            $table->foreignId('addon_id')->nullable()->default(null)->references('id')->on('addons');
//            $table->foreignId('size_variation_id')->nullable()->default(null)->references('id')->on('variations_v2');
//
//        });
        Schema::table('cart_items', function (Blueprint $table) {
           $table->unsignedBigInteger('restaurant_id');
           $table->foreign('restaurant_id')->references('id')->on('restaurants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
//    public function down()
//    {
//        Schema::dropIfExists('cart_items');
//    }
};
