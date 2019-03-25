<?php

namespace App\Classes\Parsers;

use App\Models\Parser;
use App\Classes\Parsers\HomeDepot;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Redirect;

class ParserLoader {
    public function scrape(String $parser, String $parsedUrl, $request) {
        switch($parser) {
            case 'DieCastDropshipper':
                $command = "python /vagrant/app/Classes/Parsers/DieCastDropshipper.py $parsedUrl";
                break;
            case 'HomeDepot':
                $command = "python /vagrant/app/Classes/Parsers/HomeDepot.py $parsedUrl";
                break;
            default:
                $request->session()->put('error', 'No parsers created for: ' . $parser);
                return Redirect::back();
        }

        $process = new Process($command);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
