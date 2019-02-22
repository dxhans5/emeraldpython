<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
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
        $companies = [];
        return view('companies.listings', ['companies' => $companies]);
    }

    /**
     * Invokes the add form
     */
    public function add(Request $request) {
        return view('companies.add');
    }

    /**
     * Inserts the new company into the database
     */
    public function save(Request $request) {
        print_r('here now'); die();
    }
}
