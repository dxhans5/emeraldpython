<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Classes\eBayAPI\GetMyeBaySelling;

class DashboardController extends Controller
{
    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Invokes the dashboard template
     */
    public function __invoke() {
        $listings = GetMyeBaySelling::handle();

        print_r($listings); die();
        return view('dashboard');
    }
}
