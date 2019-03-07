<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PoliciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('policies')->insert(
            [
                'policy_type' => 'return',
                'title' => 'Home Depot - Return',
                'description' => 'Most new, unopened merchandise sold can be returned within 90 days of purchase. Original shipping charges will be fully refunded in the event that the return is the result of an error. Exceptions may apply (including Express Delivery and Major Appliance). Items must be returned with all components for a full refund.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('policies')->insert(
            [
                'policy_type' => 'shipping',
                'title' => 'Home Depot - Shipping',
                'description' => 'FREE standard shipping and residential delivery on most orders. This offer is valid on parcel and residential delivery only; it does not include express or expedited shipping. We reserve the right to change or end this offer at any time. We cannot ship to Alaska, Hawaii, APO/FPO, P.O. Boxes, or U.S. Territories. Please allow 3-5 business days for parcel ground delivery and 5-10 business days for home delivery in addition to order processing time which varies by product.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
