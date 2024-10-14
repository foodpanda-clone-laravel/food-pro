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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('owner_id'); // not needed
            $table->time('opening_time');
            $table->time('closing_time');
            $table->string('cuisine');
            $table->string('logo_path');
            $table->enum('business_type', ['Home Based Kitchen', 'Restaurant']);
            $table->softDeletes();
            $table->foreign('owner_id')->references('id')->on('restaurant_owners')->onDelete('cascade');
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
        Schema::dropIfExists('restaurants');
    }
};
