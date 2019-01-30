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
        $data = $this->scrape($url);
        $data->filter('.product-title__title')->each(function($node){
            $this->title = $node->text();
        });
        $this->description = $data->filter('.main_description')->text();


        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
