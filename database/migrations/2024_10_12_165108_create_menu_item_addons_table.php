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
        Schema::create('menu_item_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade'); // Foreign key to menu_items
            $table->foreignId('addon_id')->constrained()->onDelete('cascade'); // Foreign key to addons
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
        Schema::dropIfExists('menu_item_addons');
    }
};
