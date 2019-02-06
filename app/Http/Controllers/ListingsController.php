<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Facades\App\Classes\eBayAPI\GetMyeBaySelling;
use Facades\App\Classes\eBayAPI\GetCategorySpecifics;
use Facades\App\Classes\eBayAPI\GetSuggestedCategories;
use Facades\App\Classes\eBayAPI\GetCategoryFeatures;
use Facades\App\Classes\Parsers\ParserLoader;
use Facades\App\Models\Parser;

// Parsers
use App\Classes\Parsers\HomeDepot;

class ListingsController extends Controller
{
    private $listing;
    private $listing_type = 'FixedPriceItem';
    private $listing_duration = 31; // 31 Days
    private $autopay = true;
    private $condition_id = 1000; // New w/ Tags
    private $country = 'US';
    private $currency = 'USD';
    private $item_location = 'Boise, ID USA';
    private $dispatch_max_time = 1; // One Day
    private $include_recommendations = true;
    private $payment_methods = ['PayPal'];
    private $paypal_email_address = 'info@the-vaping-pug.com';

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

        print_r($productScrape); die();

        return $this->listing;
    }

    /*
     *      getPictureDetails
     *      Creates the picture details for a listing
     */
    private function getPictureDetails($scrape) {
        print_r($scrape);
        die();
    }

    /*
     *      getCategorySuggestions
     *      Returns the suggestions for a given category
     */
    private function getCategorySuggestions($request, String $title) {
        $query = $this->formatForCategorySuggestions($title);

        return GetSuggestedCategories::handle($request, $query);
    }

    /*
     *      formatForCategorySuggestions
     *      Formats the title to remove all unneccesary items used for category suggestions
     */
    private function formatForCategorySuggestions(String $title) {
        $removePhrases = [
            'in.'
        ];
        $query = preg_replace("/[0-9]+/", "", $title);
        $query = preg_replace("/(^| ).( |$)/", "", $query);

        foreach($removePhrases as $phrase) {
            $query = preg_replace("/$phrase/", "", $query);
        }

        return $query;
    }

    /*
     *      clean
     *      Cleans the input by trimming and removing extra whitespace
     */
    private function clean(String $string) {
        $string = trim($string);
        $string =  preg_replace('/\s+/', ' ', $string);

        return $string;
    }
}
