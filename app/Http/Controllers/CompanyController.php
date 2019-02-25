<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct(Company $company)
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
     * Invokes the create form
     */
    public function create(Request $request) {
        if($request->isMethod('POST')) {
            // Submit the company to the database

        } else {
            // Just show the view for the form
            return view('companies.create');
        }
    }
}
