<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Classes\Parsers\ParserLoader;

class ProductController extends Controller {

    private $products = null;

    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->products = new Product();
    }

    /**
     * Invokes the create form
     */
    public function create(Request $request) {
        if($request->isMethod('POST')) {
            $parser = new ParserLoader;
            $company = new Company;
            $product = new Product;

            $company = $company->where('id', $request->get('companyId'))->first();
            $scrape = json_decode($parser->scrape($company->parser, $request->get('url')));

            $bulletsMarkup = "";
            if(!empty($scrape->bullets)) {
                $bulletsMarkup .= "<ul>";
                foreach($scrape->bullets as $bullet) {
                    $bulletsMarkup .= "<li>$bullet</li>";
                }
                $bulletsMarkup .= "</ul>";
            }

            $product->title = $scrape->title;
            $product->productId = $scrape->productId;
            $product->brand = $scrape->brand;
            $product->bullets = $bulletsMarkup;
            $product->dimensions = json_encode($scrape->dimensions); // Getting passed to vue component
            $product->details = json_encode($scrape->details); // Getting passed to vue component
            $product->sku = $scrape->sku;
            $product->model = $scrape->model;
            $product->description = $scrape->description;
            $product->company = $company;
            $product->images = json_encode($scrape->images); // Getting passed to vue component
            $product->scrape = $scrape;

            return view('products.create_2', ['product' => $product]);
        } else {
            # Get the companies for the scrape dropdown
            $companies = new Company;
            $companies = $companies->all();

            return view('products.create', ['companies' => $companies]);
        }
    }

    /**
     * Invokes the product list
     */
    public function list(Request $request) {
        $products = [];
        return view('products.listings', ['products' => $products]);
    }

    /**
     * Submit the product to the database
     */
    private function submitProduct(Request $request, String $id = null) {
        if(empty($id)) {
            $product = new Product;
        } else {
            $product = $product->where('id', $id)->first();
        }

        // Get items from the form here
        $product->save();
    }
}
