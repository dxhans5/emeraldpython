<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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

            if(!empty($scrape)) {

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
                $product->dollars = $scrape->dollars;
                $product->cents = $scrape->cents;
                $product->description = $scrape->description;
                $product->company = $company;
                $product->images = json_encode($scrape->images); // Getting passed to vue component
                $product->scrape = $scrape;

                return view('products.create_2', ['product' => $product]);
            } else {
                // Something screwed up...
                session()->forget('error'); // just in case there are errors left over from something (edge case)
                session()->flash('error', 'There was an issue parsing the website.');
                return back()->withInput(Input::all());
            }
        } else {
            // Get the companies for the scrape dropdown
            $companies = new Company;
            $companies = $companies->all();

            return view('products.create', ['companies' => $companies]);
        }
    }

    /**
     * Invokes the product list
     */
    public function list(Request $request) {
        $products = Product::all();
        return view('products.listings', ['products' => $products, 'productController' => $this]);
    }

    /**
     * Submit the product to the database
     */
    public function submit(Request $request) {
        $company = Company::where('name', $request->company)->first();
        $product = Product::where('product_id', $request->product_id)->first();
        if(empty($product)) {
            $product = new Product;
        }

        $product->product_id = $request->get('product_id');
        $product->company_id = $company->id;
        $product->title = $this->sanitize($request->title);
        $product->bullet_points = $this->sanitize($request->bullet_points);
        $product->sku = $this->sanitize($request->sku);
        $product->brand = $this->sanitize($request->brand);
        $product->model = $this->sanitize($request->model);
        $product->images = json_encode($request->imgs);
        $product->description = $this->sanitize($request->description);

        $product->save();

        return redirect('products');
    }

    /**
     * Returns the first image in an array of images
     */
    public function getFirstImage(Product $product) {
        //print_r($product->images); die();
    }
}
