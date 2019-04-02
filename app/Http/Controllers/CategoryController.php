<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Facades\App\Models\Category;
use App\Classes\ebay\ebayInterface;

class CategoryController extends Controller
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
        $categories = Category::all();
        return view('categories.listings', ['categories' => $categories]);
    }

    /**
     * Invokes the create form
     */
    public function create(Request $request) {
        if($request->isMethod('POST')) {
            $category = Category::where('category_id', $request->category_id)->first();
            if(empty($category)) {
                $category = new Category;
                $category->category_id = (string) Str::uuid();
            }

            print_r('stopping at create categories'); die();

            $policy->save();

            return redirect('categories');
        } else {
            return view('categories.create');
        }
    }

    /**
     * Invokes the edit form (reuses the create form with different input)
     */
    public function edit(Request $request, String $id) {
        $category = Category::where('id', $id)->first();

        return view('categories.create', ['category' => $category]);
    }

    /**
     * Updates all of the eBay Categories
     */
    public function ebayUpdate(Request $request) {
        $options = [
            'DetailLevel' => 'ReturnAll'
        ];
        $ebay = new ebayInterface();
        $response = json_decode($ebay->run('Trading', 'GetCategories', addslashes(json_encode($options)), 'True'));

        if(isset($response->Ack) && $response->Ack == 'Failure') {
            $this->processEbayAPIErrors($response);
        }

        $this->processEbayCategories($response);

        $categories = Category::all();
        return view('categories.listings', ['categories' => $categories]);
    }

    /**
     * Processes and saves the ebay categories
     */
    private function processEbayCategories($categories) {
        foreach($categories->CategoryArray->Category as $category) {
            print_r($categories->CategoryArray); die();
        }
    }
}
