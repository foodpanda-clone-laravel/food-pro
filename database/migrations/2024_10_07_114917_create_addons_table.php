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
//        Schema::create('addons', function (Blueprint $table) {
//            $table->id();
//            $table->string('name');
//            $table->string('category');
//            $table->unsignedBigInteger('restaurant_id');
//            $table->float('price');
//            $table->json('choice_items')->nullable()->default(null);
//            $table->json('choice_name')->nullable()->default(null);
//            $table->foreignId('menu_item_id')->nullable()->references('id')->on('menu_items');
//            $table->softDeletes();
//            $table->timestamps();
//        });

//        Schema::table('addons', function (Blueprint $table) {
//           $table->float('addon_price');
//        });
//        Schema::table('addons', function (Blueprint $table) {
//           $table->foreignId('choice_group_id')->nullable()->default(null)->references('id')->on('choice_groups')->constrained()->onDelete('cascade');
//        });
//        Schema::table('addons', function (Blueprint $table) {
//           $table->foreignId('choice_group_id')->nullable()->default(null)->references('id')->on('choice_groups')->constrained()->onDelete('cascade');
//        });

            //ALTER TABLE your_table_name
        //RENAME COLUMN addon_price TO price;

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
//    public function down()
//    {
//        Schema::dropIfExists('addons');
//    }
};
