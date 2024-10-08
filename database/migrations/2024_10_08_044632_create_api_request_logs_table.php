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
        Schema::create('api_request_logs', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->string('controller_action');
            $table->string('middleware');
            $table->string('path');
            $table->string('status')->default('pending');
            $table->string('duration')->nullable()->default(null);
            $table->string('ip_address');

            $table->text('request_headers');
            $table->text('request_payload')->nullable()->default(null);
            $table->text('request_params')->nullable()->default(null);
            $table->text('response_headers')->nullable()->default(null);
            $table->text('response_json')->nullable()->default(null);
            $table->string('memory_usage')->nullable()->default(null);
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
        Schema::dropIfExists('api_request_logs');
    }
};
