<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert(
            [
                'name' => 'Home Depot',
                'url' => 'https://www.homedepot.com',
                'parser' => 'HomeDepot',
                'return_policy_id' => 1,
                'shipping_policy_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('companies')->insert(
            [
                'name' => 'BryBelly',
                'url' => 'https://www.brybelly.com',
                'parser' => 'BryBelly',
                'return_policy_id' => 1,
                'shipping_policy_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('companies')->insert(
            [
                'name' => 'diecastdropshipper.com',
                'url' => 'https://www.diecastdropshipper.com',
                'parser' => 'DieCastDropshipper',
                'return_policy_id' => 1,
                'shipping_policy_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
