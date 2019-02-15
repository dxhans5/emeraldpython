<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ParsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parsers')->insert(
            [
                'host' => 'www.homedepot.com',
                'parser' => 'HomeDepot',
                'company_id' => 1, // Home Depot
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
