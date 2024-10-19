<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('branch_id');
            $table->float('total_amount');
            $table->enum('status', ['in_progress','delivered', 'canceled']);
            $table->enum('order_type', ['delivery', 'takeaway']);
            $table->float('delivery_charges');
            $table->datetime('estimated_delivery_time');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('delivery_address');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
