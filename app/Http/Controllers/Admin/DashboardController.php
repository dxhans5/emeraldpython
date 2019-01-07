<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    /**
     * Invokes the dashboard template
     */
    public function __invoke() {
        return view('admin.dashboard');
    }
}
