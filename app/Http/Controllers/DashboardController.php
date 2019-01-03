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
    }

    /**
     * Invokes the dashboard template
     */
    public function __invoke() {
        return view('dashboard');
    }
}
