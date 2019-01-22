<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_services', function (Blueprint $table) {
            $table->increments('id');
            $table->double('additional_shipping_cost', 5, 2)->default(0.00);
            $table->boolean('buyer_responsible_for_pickup')->default(false);
            $table->boolean('buyer_responsible_for_shipping')->default(false);
            $table->double('cash_on_delivery_fee', 5, 2)->default(0.00);
            $table->boolean('free_shipping')->default(false);
            $table->string('shipping_carrier_code');
            $table->double('shipping_cost', 5, 2)->default(0.00);
            $table->string('shipping_service_code');
            $table->string('region_included')->nullable()->default(null); // Part of the RegionSet
            $table->string('region_excluded')->nullable()->default(null); // Part of the RegionSet
            $table->integer('sort_order')->default(1);
            $table->double('surcharge', 5, 2)->default(0.00);
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
        Schema::drop('shipping_services');
    }
}
