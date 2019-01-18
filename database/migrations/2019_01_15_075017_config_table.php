<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->text('client_token');
            $table->string('client_token_expires_at');
            $table->string('client_token_type');
            $table->text('user_token')->nullable()->default(null);
            $table->string('user_token_expires_at')->nullable()->default(null);
            $table->string('user_refresh_token')->nullable(true);
            $table->string('user_token_type')->nullable(true);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('config');
    }
}
