<?php

namespace App\Classes\Parsers;

class Parser {

    // Required data
    public $title;
    public $description;
    public $brand;

    protected function scrape($url) {
        switch($parser->parser) {
            case 'HomeDepot':
                $data = passthru("python HomeDepot.py $url");
                break;
            default:
                $request->session()->put('error', 'No parsers created for: ' . $host);
                return Redirect::back();
        }

        print_r($data);
    }
}
