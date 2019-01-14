<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FulfillmentPolicies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fulfillment_policies', function (Blueprint $table) {
            $table->string('fulfillment_policy_id'); // provided from ebay when the policy is actually created
            $table->string('name');
            $table->enum('category_type', array('MOTORS_VEHICLES', 'ALL_EXCLUDING_MOTORS_VEHICLES'));
            $table->text('description');
            $table->boolean('freight_shipping')->default(false);
            $table->boolean('global_shipping')->default(false);
            $table->enum('handling_time_unit', array('YEAR', 'MONTH', 'DAY', 'HOUR', 'CALENDAR_DAY', 'BUSINESS_DAY', 'MINUTE', 'SECOND', 'MILLISECOND'));
            $table->integer('handling_time_value');
            $table->boolean('local_pickup')->default(false);
            $table->string('marketplace_id');
            $table->boolean('pickup_dropoff')->default(false);
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
        Schema::drop('fulfillment_policies');
    }
}
