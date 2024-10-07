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
            $table->unsignedBigInteger('owner_id');
            $table->integer('branch_id');
            $table->string('address');
            $table->string('postal_code');
            $table->string('city');
            $table->datetime('opening_time')->nullable()->default(null);
            $table->datetime('closing_time')->nullable()->default(null);
            $table->string('cuisine');
            $table->string('logo_path')->nullable()->default(null);
            $table->string('business_type');
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
