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
        Schema::create('restaurant_requests', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('postal_code');
            $table->string('city');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->string('business_type');
            $table->string('cnic')->unique();
            $table->string('bank_name');
            $table->enum('status', ['pending', 'approved', 'declined']);
            $table->string('iban')->unique();
            $table->string('account_owner_title');
            $table->string('cuisine');
            $table->string('restaurant_name');
            $table->string('logo_path');  // Store the image path
            $table->timestamps();  // created_at, updated_at
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_requests');
    }
};
