<?php

namespace App\Classes\ebay;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ebayInterface {
    public function run(String $endpoint, JSON $payload) {
        $command = "python /vagrant/app/Classes/ebay/ebay.py $endpoint $payload";

        $process = new Process($command);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
