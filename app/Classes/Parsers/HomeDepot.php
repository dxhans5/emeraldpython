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
        $this->brand = $data->filter('.product-title__brand .bttn__content')->text();

        $thumbnails = $data->filter('.media__thumbnail > img')->each(function($node){
            $src = $node->attr('src');
            var_dump($src);
        });

        die();


        return [
            'title' => $this->title,
            'description' => $this->description,
            'brand' => $this->brand,
        ];
    }
}
