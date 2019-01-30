<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Facades\App\Classes\eBayAPI\GetMyeBaySelling;
use Facades\App\Classes\eBayAPI\GetCategorySpecifics;
use Facades\App\Classes\Parsers\ParserLoader;
use Facades\App\Models\Parser;

// Parsers
use App\Classes\Parsers\HomeDepot;

class ListingsController extends Controller
{
    private $listing;
    private $autopay = true;
    private $condition_id = 1000; // New w/ Tags
    private $country = 'US';
    private $currency = 'USD';
    private $dispatch_max_time = 1; // One Day
    private $include_recommendations = true;

    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access.token');
    }

    /**
     *      listings
     *      Invokes the listing template
     */
    public function listings(Request $request) {
        $listings = GetMyeBaySelling::handle($request);

        return view('listings.listings', ['listings' => $listings]);
    }

    /**
     *      create
     *      Invokes the create template
     */
    public function create(Request $request) {
        return view('listings.create');
    }

    /**
     *      save
     *      Saves the listing
     */
    public function save(Request $request) {
        $url = $request->get('url');
        $parsedUrl = parse_url($request->get('url'));
        $host = $parsedUrl['host'];
        if(!$parser = Parser::where('host', $host)->first()) {
            $request->session()->put('error', 'No parsers created for: ' . $host);
            return Redirect::back();
        }

        $listing = $this->createListing($parser, $url, $request);

    }

    private function createListing($parser, String $url, Request $request) {
        $productScrape = ParserLoader::loadAndScrape($parser, $url);
        $this->listing = new \stdClass();
        $this->listing->ApplicationData = (string)Str::uuid();
        $this->listing->AutoPay = $this->autopay;
        $this->listing->ConditionID = $this->condition_id;
        $this->listing->Country = $this->country;
        $this->listing->Currency = $this->currency;
        $this->listing->Description = $this->clean($productScrape->description);
        $this->listing->DispatchTimeMax = $this->dispatch_max_time;
        $this->listing->IncludeRecommendations = $this->include_recommendations;
        $this->listing->ItemSpecifics = GetCategorySpecifics::handle($request);

        $this->listing->title = $this->clean($productScrape->title);

        echo('<pre>');
        print_r($this->listing);
        echo('</pre>');
        die();

        return $this->listing;
    }

    private function clean(String $string) {
        $string = trim($string);
        $string =  preg_replace('/\s+/', ' ', $string);

        return $string;
    }
}
