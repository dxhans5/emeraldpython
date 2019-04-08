<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('category_id');
            $table->string('name');
            $table->string('category_path')->nullable()->default(NULL);
            $table->integer('level');
            $table->integer('parent_id');
            $table->boolean('autopay_enabled')->default(false);
            $table->boolean('b2bvat_enabled')->default(false);
            $table->boolean('best_offer_enabled')->default(false);
            $table->boolean('leaf_category')->default(false);
            $table->boolean('lsd')->default(false);
            $table->boolean('orpa')->default(false);
            $table->boolean('orra')->default(false);
            $table->boolean('virtual')->default(false);
            $table->dateTime('prev_ebay_update')->nullable()->default(null);
            $table->dateTime('last_ebay_updated');
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
        Schema::dropIfExists('categories');
    }
}
