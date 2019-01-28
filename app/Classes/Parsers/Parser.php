<?php

namespace App\Classes\Parsers;

use Goutte\Client;

class Parser {

    protected function scrape($url) {
        $client = new Client();

        return $client->request('GET', $url);
    }
}
