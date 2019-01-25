<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_options', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('cost_type', array('FLAT_RATE', 'CALCULATED', 'NOT_SPECIFIED'));
            $table->double('insurance_fee', 5, 2);
            $table->boolean('insurance_offered')->default(false);
            $table->enum('option_type', array('DOMESTIC', 'INTERNATIONAL'));
            $table->double('package_handling_cost', 5, 2);
            $table->string('rate_table_id')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
