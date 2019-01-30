<?php

namespace App\Classes\Parsers;

use Goutte\Client;

class Parser {

    // Required data
    public $title;
    public $description;

    protected function scrape($url) {
        $client = new Client();
        return $client->request('GET', $url);
    }
}
