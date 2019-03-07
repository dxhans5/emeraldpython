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
            //$scrape = json_decode($parser->scrape($company->parser, $request->get('url')));
            $json = '{"sku": "621433", "dimensions": {"Product Width (in.)": "12.7", "Product Depth (in.)": "18.11", "Product Height (in.)": "10.2"}, "title": "Mechanics Tool Set (268-Piece)", "brand": "Husky", "bullets": ["72-tooth ratchets need an only 5\u00b0 arc swing to turn fasteners", "Plastic storage case is stamped with size markings for easy identification and organization", "Quick release button allows sockets and drive tools to be easily removed from the ratchet", "Full polished chrome finish easily wipes clean of oil and dirt", "72-tooth quick release ratchet", "Wrenches feature a 12-point box-end design and 15\u00b0 offset increases clearance", "Set includes three 1/4, 3/8 and 1/2 in. dr. quick release ratchets, 23 standard length 1/4 dr. 6-pt. socket, 10 standard length 1/4 dr. 12-pt. socket, 21 deep 1/4 dr. 6-pt. socket, 28 standard length 3/8 dr. 6-pt. socket, 5 standard length 3/8 dr. 8-pt. socket, 22 standard length 3/8 dr. 12-pt. socket, 16 deep 3/8 dr. 6-pt. socket, two 3/8 dr. spark plug socket, nineteen 3/8 dr. bit socket, 22 standard length 1/2 dr. 12-pt. socket, 20 combination wrenches and 77 other accessory and dr. tools", "Bit sockets attached to 3/8 in. drive tools provide a longer handle and more leverage than standard hex keys or screwdrivers", "Hex keys, screwdriver and nut driver bits are formed from heat-treated S2 tool steel for added strength and wear protection", "Sockets and wrenches are designed with off-corner loading to help prevent rounding of fasteners", "Sockets and wrenches feature chamfered lead-ins help to provide fast and easy placement onto drive tools and fasteners", "Lifetime warranty with no questions, no receipt required", "Tools are forged from chromium-vanadium (Cr-V) steel for outstanding durability and strength", "Lifetime Warranty with no questions, no receipt required", "Large, hard-stamped size markings allow for easy readability", "Includes 168 sockets, 67 accessories, 30 wrenches, & 3 ratchets", "Chrome finish provides corrosion resistance and added durability", "Call 1-888-HD-HUSKY or visit HuskyTools.com for customer service and support"], "details": {"Color Family": "Silver", "Individual/Set": "Set", "Multiple Tool Set Type": "Mechanic Sets", "Tools Included": "Combination Wrench,Hex Keys,Multi-Bit Screwdriver,Nut Driver Bits,Ratchet,Screwdriving Bits,Sockets", "Returnable": "90-Day", "Tools Product Type": "Hand Tool", "Hand Tool Type": "Tool Set", "Number of Pieces": "268"}, "images": ["2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-64_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-e1_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-40_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-1d_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-66_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-77_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-c3_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-4f_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-1f_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-44_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-fa_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-76_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-d4_1000.jpg", "2ca4b060-d426-4a3a-87da-8eec350031ea/husky-mechanics-tool-sets-h268mts-31_1000.jpg"], "model": "H268MTS", "productId": "2ca4b060-d426-4a3a-87da-8eec350031ea", "price": "199.00", "description": "The Husky 268-piece 1/4 in, 3/8 in. and 1/2 in. drive mechanics tool set is one of the most comprehensive tools set for professional or DIY mechanics workshop. The 168 different standard and deep sockets along with the 20 combination wrenches and 19 bit sockets will allow you to tackle any fastening or repair project. This Husky 268-piece tool set will provide the novice or professional with a huge assortment of durable and reliable tools to get the job done."}';
            $scrape = json_decode($json);

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
    public function submit(Request $request, String $id = null) {
        $company = new Company;
        $company = $company->where('name', $request->company)->first();

        if(empty($id)) {
            $product = new Product;
        } else {
            $product = $product->where('id', $id)->first();
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

        // Get items from the form here
        $product->save();
    }
}
