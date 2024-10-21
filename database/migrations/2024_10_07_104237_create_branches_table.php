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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('postal_code');
            $table->string('city');
            $table->float('delivery_fee');
            $table->string('delivery_time')->default('Standard 15 to 30 minutes');
            $table->foreignId('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *w
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
