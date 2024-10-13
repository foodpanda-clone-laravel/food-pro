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
        Schema::create('assigned_choice_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->nullable()->default(null)->constrained()->onDelete('cascade'); // Foreign key to menu_items
            $table->foreignId('choice_group_id')->nullable()->default(null)->constrained()->onDelete('cascade'); // Foreign key to menu_items
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
        Schema::dropIfExists('assigned_choice_groups');
    }
};
