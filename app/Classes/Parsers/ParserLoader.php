<?php

namespace App\Classes\Parsers;

use App\Models\Parser;
use App\Classes\Parsers\HomeDepot;

class ParserLoader {
    public function loadAndScrape(Parser $parser, String $parsedUrl) {
        switch($parser->parser) {
            case 'HomeDepot':
                $command = "python app/Classes/Parsers/HomeDepot.py $parsedUrl";
                break;
            default:
                $request->session()->put('error', 'No parsers created for: ' . $host);
                return Redirect::back();
        }

        ob_start();
        exec($command);
        $result = ob_get_contents();
        ob_end_clean();
        print_r($result);
        print_r("Done.");
    }
}
