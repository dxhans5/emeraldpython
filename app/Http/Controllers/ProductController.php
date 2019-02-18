<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
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
        $products = [];
        return view('products.listings', ['products' => $products]);
    }
}
