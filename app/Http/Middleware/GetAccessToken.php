<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Config;
use Illuminate\Support\Facades\DB;

class GetAccessToken
{

    private $RESOURCE_URI = 'https://api.sandbox.ebay.com/identity/v1/oauth2/token';
    private $client;
    private $headers;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Setup the Guzzle client
        $this->client = new Client(
            ['base_uri' => $this->RESOURCE_URI]
        );

        // Setup the headers
        $this->headers = [
            'Authorization' => 'Basic ' . base64_encode(env('EBAY_CREDS')),
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('access_token')) {
            // check to see if access_token has/or about to expire
                // go update the access_token in the DB
                // update the session with the new access_token
        } else {
            $this->mint_token($request);
        }

        return $next($request);
    }

    /**
     * Mint and store a new access_token
     *
     * @return string
     */
    private function mint_token($request) {
        $options = [
            'headers' => $this->headers,
            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope' => 'https://api.ebay.com/oauth/api_scope'
            ]
        ];

        try {
            $response = $this->client->post('', $options);
            $token = json_decode($response->getBody()->getContents());

            // Is there already a minted token in the DB?
            if($minted_token = DB::table('config')->first()){

            }
            print_r($minted_token);
                // Retrieve the minted token to update it
            // Otherwise
                // Create a new minted token

            // Store token in the database
            $config = new Config;
            $config->access_token = $token->access_token;
            $config->expires_in = Carbon::now()->addSeconds($token->expires_in);
            $config->refresh_token = isset($token->refresh_token) ? $token->refresh_token : null;
            $config->token_type = $token->token_type;
            $config->save();

            // Store token in the session
            $request->session()->put('access_token', $config->access_token);
        } catch (RequestException $e) {
            print_r(json_decode($e->getResponse()->getBody()->getContents()));
        }

        return $config->access_token;
    }
}
