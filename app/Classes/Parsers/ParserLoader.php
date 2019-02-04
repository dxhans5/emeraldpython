<?php

namespace App\Classes\Parsers;

use App\Models\Parser;
use App\Classes\Parsers\HomeDepot;

class ParserLoader {
    public function loadAndScrape(Parser $parser, String $parsedUrl) {
        switch($parser->parser) {
            case 'HomeDepot':
                $command = "python /vagrant/app/Classes/Parsers/HomeDepot.py $parsedUrl";
                break;
            default:
                $request->session()->put('error', 'No parsers created for: ' . $host);
                return Redirect::back();
        }

        print_r($command); die();
        return exec($command);
    }
}
