<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * Invokes the dashboard template
     */
    public function __invoke(Request $request) {
        return view('dashboard');
    }
}
