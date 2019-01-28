<?php

namespace App\Classes\Parsers;

use App\Classes\Parsers\Parser;

class HomeDepot extends Parser {

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(String $url)
    {
        $scrape = $this->scrape($url);
        $scrape->filter('.price__dollars')->each(function ($node) {
            print_r($node);
        });

        die();
    }
}
