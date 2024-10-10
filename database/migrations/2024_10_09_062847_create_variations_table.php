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
            $table->unsignedBigInteger('menu_id'); // menu item id to insert variation against that particular item
            $table->json('choice_items'); // Use json type here
            $table->string('choice_name'); // title of the choice group like choose your drink.
            $table->string('choice_category'); // category of the chosen item like bread, size, flavour, grilled or smoked?? etc
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
