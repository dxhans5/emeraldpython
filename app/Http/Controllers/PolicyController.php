<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;

class PolicyController extends Controller
{

    private $policy;

    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->policy = new Policy;
    }

    /**
     * Invokes the product list
     */
    public function list(Request $request) {
        $policies = $this->policy->all();
        return view('policies.listings', ['policies' => $policies]);
    }

    /**
     * Invokes the create form
     */
    public function create(Request $request) {
        if($request->isMethod('POST')) {
            // Do post stuff here
        } else {
            return view('policies.create', ['policy' => $this->policy]);
        }
    }
}
