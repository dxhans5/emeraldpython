<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Classes\eBayAPI\GetMyeBaySelling;

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
     * Invokes the listing template
     */
    public function listings(Request $request) {
        $listings = GetMyeBaySelling::handle($request);

        return view('listings', ['listings' => $listings]);
    }
}
