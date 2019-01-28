<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Facades\App\Classes\eBayAPI\GetMyeBaySelling;
use Facades\App\Classes\Parsers\ParserLoader;
use Facades\App\Models\Parser;

// Parsers
use App\Classes\Parsers\HomeDepot;

class ListingsController extends Controller
{
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

        $scrape = ParserLoader::loadAndScrape($parser, $url);
        print_r($scrape); die();


        // Scrape the URL
        // Collect data from the request
        // Clean all of the data
        // if VerifyAddItem
            // AddItem w/ UUID
        // else
            // Toast form (keeping data)

    }
}
