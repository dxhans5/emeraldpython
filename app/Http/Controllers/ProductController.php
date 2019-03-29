<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Classes\ebay\ebayInterface;
use Facades\App\Models\Company;
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
            $product = new Product;

            $company = Company::where('id', $request->get('companyId'))->first();
            $scrape = json_decode($parser->scrape($company->parser, $request->get('url'), $request));

            if(!empty($scrape)) {

                $bulletsMarkup = "";
                if(!empty($scrape->bullet_points)) {
                    $bulletsMarkup .= "<ul>";
                    foreach($scrape->bullet_points as $bullet) {
                        $bulletsMarkup .= "<li>$bullet</li>";
                    }
                    $bulletsMarkup .= "</ul>";
                }

                $product->title = $scrape->title;
                $product->product_id = $scrape->product_id;
                $product->brand = $scrape->brand;
                $product->bullet_points = $bulletsMarkup;
                if(isset($scrape->dimensions)) {
                    $product->dimensions = json_encode($scrape->dimensions); // Getting passed to vue component
                }
                if(isset($scrape->details)) {
                    $product->details = json_encode($scrape->details); // Getting passed to vue component
                }
                $product->sku = $scrape->sku;
                if(isset($scrape->model)) {
                    $product->model = $scrape->model;
                }
                if(isset($scrape->description)) {
                    $product->description = $scrape->description;
                }
                $product->price = $scrape->price;
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
            $companies = Company::orderBy('name')->get();

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
        $product->price = $this->sanitize($request->price);
        $product->images = $request->imgs;
        $product->description = $this->sanitize($request->description);

        $product->save();

        return redirect('products');
    }

    /**
     * Invokes the edit form (reuses the create form with different input)
     */
    public function edit(Request $request, String $id) {
        $product = $this->products->where('id', $id)->first();

        // NiceEdit will not display HTML without doing this:
        $product->description = html_entity_decode($product->description);
        $product->bullet_points = html_entity_decode($product->bullet_points);

        return view('products.create_2', ['product' => $product]);
    }

    /**
     * Returns the first image in an array of images
     */
    public function getFirstImage(Product $product) {
        return json_decode($product->images)[0];
    }

    /**
     * Toggles the status of a product (active, disabled)
     */
    public function toggleStatus(Request $request, String $id) {
        $product = $this->products->where('id', $id)->first();

        $product->status == 'active' ? $product->status = 'disabled' : $product->status = 'active';
        $product->save();

        return redirect('products');
    }

    /**
     * Manipulates an ebay ad from the product data
     */
    public function ebayAd(Request $request, String $id) {
        $product = $this->products->where('id', $id)->first();

        $item = [
            'Item' => [
                'Currency' => 'USD'
            ]
        ];

        $ebay = new ebayInterface();
        $response = json_decode($ebay->run('Trading', 'AddItem', addslashes(json_encode($item))));

        if($response->Ack == 'Failure') {
            $errors = [];
            foreach($response->Errors as $error) {
                $errors[] = "Ebay: " . $error->ShortMessage;
                // Something screwed up...
                session()->forget('errors'); // just in case there are errors left over from something (edge case)
                session()->flash('errors', $errors);
                return back();
            }
        }

        return $response;
    }

}
