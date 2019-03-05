<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id');
            $table->string('title');
            $table->string('bullet_points')->nullable()->default(NULL);
            $table->string('dimensions')->nullable()->default(NULL);
            $table->string('weight')->nullable()->default(NULL);
            $table->string('batteries')->nullable()->default(NULL);
            $table->string('asin')->nullable()->default(NULL);
            $table->string('upc')->nullable()->default(NULL);
            $table->string('sku')->nullable()->default(NULL);
            $table->string('brand')->nullable()->default(NULL);
            $table->string('model')->nullable()->default(NULL);
            $table->string('images')->nullable()->default(NULL);
            $table->text('description');
            $table->integer('company_id');
            $table->integer('warranty_policy_id');
            $table->integer('shipping_policy_id');
            $table->integer('return_policy_id');
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
        Schema::dropIfExists('products');
    }
}
