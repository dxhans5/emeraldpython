<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Invokes the product list
     */
    public function list(Request $request) {
        $policies = [];
        return view('policies.listings', ['policies' => $policies]);
    }
}
