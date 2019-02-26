<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    private $companies = null;

    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct() {
        $this->middleware('auth');

        $this->companies = new Company();
    }

    /**
     * Invokes the product list
     */
    public function list(Request $request) {
        $companies = $this->companies->all();
        return view('companies.listings', ['companies' => $companies]);
    }

    /**
     * Invokes the create form
     */
    public function create(Request $request) {
        if($request->isMethod('POST')) {
            $this->submitCompany($request);

            return redirect('companies/');
        } else {
            // Just show the view for the form
            return view('companies.create');
        }
    }

    /**
     * Details the company
     */
    public function detail(Request $request, String $id) {
        if($request->isMethod('POST')) {
            $this->submitCompany($request, $id);

            return redirect('companies/');
        } else {
            $company = $this->companies->where('id', $id)->first();

            return view('companies.detail', ['company' => $company]);
        }
    }

    /**
     * Deletes the company
     */
    public function trash(Request $request, String $id) {
        $company = $this->companies->where('id', $id)->delete();

        return redirect('companies/');
    }

    /**
     * Submit the company to the database
     */
    private function submitCompany(Request $request, String $id = null) {
        if(empty($id)) {
            // Submit the company to the database
            $company = new Company;
        } else {
            $company = $this->companies->where('id', $id)->first();
        }

        $company->name = $request->get('name');
        $company->url = $request->get('url');
        $company->save();
    }
}
