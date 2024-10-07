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
        Schema::create('restaurant_owners', function (Blueprint $table) {
            $table->id();
            $table->string('cnic');
            $table->bigUnsigendInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('bank_name');
            $table->string('iban');
            $table->string('account_owner_title');
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
        Schema::dropIfExists('restaurant_owners');
    }
};
