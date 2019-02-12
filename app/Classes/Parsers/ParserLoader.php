<?php

namespace App\Classes\Parsers;

use App\Models\Parser;
use App\Classes\Parsers\HomeDepot;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ParserLoader {
    public function loadAndScrape(Parser $parser, String $parsedUrl) {
        switch($parser->parser) {
            case 'HomeDepot':
                $command = "sudo python /vagrant/app/Classes/Parsers/HomeDepot.py $parsedUrl";
                break;
            default:
                $request->session()->put('error', 'No parsers created for: ' . $host);
                return Redirect::back();
        }

        $process = new Process($command);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        print_r($process->getOutput());


        die();
    }
}
