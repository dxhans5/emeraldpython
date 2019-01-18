<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class FulfillmentPolicyController extends Controller
{
    private $client;
    private $headers;

    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access.token');

        // Setup the Guzzle client
        $this->client = new Client(
            ['base_uri' => env('EBAY_DOMAIN') . '/sell/account/v1/fulfillment_policy/']
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $marketplace_id='EBAY_US')
    {
        $uri = '?marketplace_id=' . $marketplace_id;
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . session('user_token')
            ],
            'debug' => true
        ];
        $policies = [];
        try {
            $policies = $this->client->get($uri, $options);
        } catch (RequestException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            $request->session()->flash('errors', $response);
        }

        return view('admin.fulfillment_policy.list', ['policies' => $policies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
