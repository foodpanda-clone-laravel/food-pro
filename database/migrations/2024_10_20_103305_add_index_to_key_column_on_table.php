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
        Schema::table('users', function (Blueprint $table) {
            $table->index(['id']);
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->index(['id']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['id']);
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->index(['id']);
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->index(['id']);
        });

        Schema::table('choice_groups', function (Blueprint $table) {
            $table->index(['id']);
        });
        Schema::table('choices', function (Blueprint $table) {
            $table->index(['id']);
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->index(['id']);
        });
        Schema::table('restaurant_owners', function (Blueprint $table) {
            $table->index(['id']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['id']);
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex(['id']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['id']);
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['id']);
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->dropIndex(['id']);
        });

        Schema::table('choice_groups', function (Blueprint $table) {
            $table->dropIndex(['id']);
        });
        Schema::table('choices', function (Blueprint $table) {
            $table->dropIndex(['id']);
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropIndex(['id']);
        });
        Schema::table('restaurant_owners', function (Blueprint $table) {
            $table->dropIndex(['id']);
        });

    }
};
