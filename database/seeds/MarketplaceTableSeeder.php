<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MarketplaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marketplaces')->insert([
            [
                'enum' => 'EBAY_AT',
                'location' => 'Austria',
                'url' => 'https://www.ebay.at',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_AU',
                'location' => 'Australia',
                'url' => 'https://www.ebay.com.au',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_BE',
                'location' => 'Belgium',
                'url' => 'https://www.ebay.be',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_CA',
                'location' => 'Canada',
                'url' => 'https://www.ebay.ca',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_DE',
                'location' => 'Germany',
                'url' => 'https://www.ebay.de',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_ES',
                'location' => 'Spain',
                'url' => 'https://www.ebay.es',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_FR',
                'location' => 'France',
                'url' => 'https://www.ebay.fr',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_GB',
                'location' => 'Great Britain',
                'url' => 'https://www.ebay.co.uk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_HK',
                'location' => 'Hong Kong',
                'url' => 'https://www.ebay.com.hk',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_IE',
                'location' => 'Ireland',
                'url' => 'https://www.ebay.ie',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_IN',
                'location' => 'India',
                'url' => 'https://www.ebay.in',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_IT',
                'location' => 'Italy',
                'url' => 'https://www.ebay.it',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_MY',
                'location' => 'Malaysia',
                'url' => 'https://www.ebay.com.my',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_NL',
                'location' => 'Netherlands',
                'url' => 'https://www.ebay.nl',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_PH',
                'location' => 'Philippines',
                'url' => 'https://www.ebay.ph',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_PL',
                'location' => 'Poland',
                'url' => 'https://www.ebay.pl',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_SG',
                'location' => 'Singapore',
                'url' => 'https://www.ebay.sg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_TH',
                'location' => 'Thailand',
                'url' => 'https://www.ebay.co.th',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_TW',
                'location' => 'Taiwan',
                'url' => 'https://www.ebay.com.tw',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_US',
                'location' => 'United States',
                'url' => 'https://www.ebay.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_VN',
                'location' => 'Vietnam',
                'url' => 'https://www.ebay.vn',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'enum' => 'EBAY_MOTORS_US',
                'location' => 'Auto Parts & Vehicles (US)',
                'url' => 'https://www.ebay.com/motors',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
