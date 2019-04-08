<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $categories = Category::paginate(20);

        // Update the category path if it's not set
        foreach($categories as $category) {
            if(empty($category->category_path)) {
                $category->category_path = substr($this->processCategoryPath($category), 0, -1);
                $category->save();
            }
        }
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
        return redirect('categories');
    }

    /**
     * Processes and saves the ebay categories
     */
    private function processEbayCategories($categories) {
        $bulkInsert = [];
        $categories = $categories->CategoryArray->Category;
        usort($categories, array($this, "categorySort"));

        foreach($categories as $category) {
            if(Category::where('category_id', $category->CategoryID)->count() === 0) {
                $bulkInsert[] = [
                    'category_id' => (int)$category->CategoryID,
                    'name' => $category->CategoryName,
                    'level' => $category->CategoryLevel,
                    'autopay_enabled' => (isset($category->AutoPayEnabled) && $category->AutoPayEnabled == 'true') ? true : false,
                    'best_offer_enabled' => (isset($category->BestOfferEnabled) && $category->BestOfferEnabled == 'true') ? true : false,
                    'parent_id' => (int)$category->CategoryParentID,
                    'last_ebay_updated' => Carbon::now()->toDateTimeString()
                ];
            }
        }
        $collection = collect($bulkInsert);
        $chunks = $collection->chunk(200);

        foreach($chunks as $chunk) {
            Category::insert($chunk->toArray());
        }
    }

    /**
     * Recursively creates category path
     */
    private function processCategoryPath($category, $path = '') {
        $path = $category->name . '/' . $path;

        if($category->parent_id === $category->category_id) {
            return $path;
        } else {
            $parent = Category::where('category_id', $category->parent_id)->first();
            return $this->processCategoryPath($parent, $path);
        }
    }

    /**
     * Category sorter
     */
    private function categorySort($a, $b) {
        if($a->CategoryParentID == $b->CategoryParentID) {
            return $a->CategoryParentID - $b->CategoryParentID;
        }
        return strcmp($a->CategoryID, $b->CategoryID);
    }
}
