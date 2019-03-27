<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Policy;

class PolicyController extends Controller
{

    private $policy;

    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->policy = new Policy;
    }

    /**
     * Invokes the product list
     */
    public function list(Request $request) {
        $policies = $this->policy->all();
        return view('policies.listings', ['policies' => $policies]);
    }

    /**
     * Invokes the create form
     */
    public function create(Request $request) {
        if($request->isMethod('POST')) {
            $policy = $this->policy->where('policy_id', $request->policy_id)->first();
            if(empty($policy)) {
                $policy = new Policy;
                $policy->policy_id = (string) Str::uuid();
            }

            $policy->title = $request->get('title');
            $policy->policy_type = $request->get('type');
            $policy->description = $request->get('description');

            $policy->save();

            return redirect('policies');
        } else {
            return view('policies.create', ['policy' => $this->policy]);
        }
    }

    /**
     * Invokes the edit form (reuses the create form with different input)
     */
    public function edit(Request $request, String $id) {
        $policy = $this->policy->where('id', $id)->first();

        // NiceEdit will not display HTML without doing this:
        $policy->description = html_entity_decode($policy->description);

        return view('policies.create', ['policy' => $policy]);
    }
}
