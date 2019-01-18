<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterUserTokenController extends Controller
{
    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct()
    {
        
    }

    /**
     * Invokes the dashboard template
     */
    public function register(Request $request) {
        if($request->input('state') == 'jadepython') {
            $code = $request->input('code');
        } else {
            $request->session()->flash('errors', $response);
            return view('admin.fulfillment_policy.list', ['policies' => $policies]);
        }
    }
}
