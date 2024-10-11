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
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id'); // menu item id to insert variation against that particular item
            $table->json('choice_group');
            $table->string('choice_title');
            $table->string('choice_category'); // category of the chosen item like bread, size, flavour, grilled or smoked?? etc
            $table->float('additional_price'); // if it costs additional or not
            $table->integer('min')->default(0); // if 0 then it is a addon if one then it is a required variation 
            $table->softDeletes();
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
        Schema::dropIfExists('variations');
    }
};
