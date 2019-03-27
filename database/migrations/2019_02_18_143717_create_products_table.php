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
            $table->text('bullet_points')->nullable()->default(NULL);
            $table->string('dimensions')->nullable()->default(NULL);
            $table->string('weight')->nullable()->default(NULL);
            $table->string('sku')->nullable()->default(NULL);
            $table->string('brand')->nullable()->default(NULL);
            $table->string('model')->nullable()->default(NULL);
            $table->text('images')->nullable()->default(NULL);
            $table->float('price', 5, 2)->default(0.00);
            $table->text('description');
            $table->integer('company_id');
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->boolean('ebay_ad_created')->default(false);
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
