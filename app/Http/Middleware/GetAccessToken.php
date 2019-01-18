<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Config;

class GetAccessToken
{
    private $client;
    private $headers;

    /**
     * Constructor
     */
    public function __construct()
    {

        // Setup the Guzzle client
        $this->client = new Client();

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
        $this->validateClientToken($request);
        $this->validateUserToken($request);

        return $next($request);
    }

    /**
     * Validate the user token
     *
     * @return void
     */
    private function validateUserToken($request) {
        if ($request->session()->has('user_token_expires_at')) {
            $user_token_expires_at = $request->session()->get('user_token_expires_at');
            $seconds_until_user_token_expires = Carbon::parse($user_token_expires_at)->diffInSeconds(Carbon::now());

            if($seconds_until_user_token_expires <= 1800) { // If expires in 30min or less
                $this->mintUserToken($request);
            }
        } else {
            // Mint a new user token
            $this->mintUserToken($request);
        }
    }

    /**
     * Mint and store a new user_token
     *
     * @return string
     */
    private function mintUserToken($request) {
        $options = [
            'query' => [
                'client_id' => env('EBAY_CLIENT_ID'),
                'redirect_uri' => env('EBAY_RUNAME'),
                'response_type' => 'code',
                'state' => 'jadepython',
                'scope' => 'https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.inventory',
                'prompt' => 'login'
            ]
        ];



        //print_r($options); die();

        try {
            $response = $this->client->get('https://auth.sandbox.ebay.com/oauth2/authorize', $options);
            print_r($response->getBody()->getContents());
            $token = json_decode($response->getBody()->getContents());

            $minted_token = $this->saveUserTokenToDB($token);
            $this->saveUserTokenToSession($request, $minted_token);

        } catch (RequestException $e) {
            print_r(json_decode($e->getResponse()->getBody()->getContents()));
            die();
        }
    }

    /**
     * Saves or updates a token to the DB
     *
     * @return void
     */
    private function saveUserTokenToDB($token) {
        print_r("Here?" . $token); die();
    }

    /**
     * Saves or updates a token to the session
     *
     * @return void
     */
    private function saveClientTokenToSession($request, $token) {
        // Store token in the session
        //$request->session()->put('user_token', $token->client_token);
        //$request->session()->put('user_token_expires_at', $token->expires_at);
    }

    /**
     * Validate the client token
     *
     * @return void
     */
    private function validateClientToken($request) {
        if ($request->session()->has('client_token_expires_at')) {
            $client_token_expires_at = $request->session()->get('client_token_expires_at');
            $seconds_until_client_token_expires = Carbon::parse($client_token_expires_at)->diffInSeconds(Carbon::now());

            if($seconds_until_client_token_expires <= 1800) { // If expires in 30min or less
                $this->mintClientToken($request);
            }
        } else {
            // Mint a new client token
            $this->mintClientToken($request);
        }
    }

    /**
     * Mint and store a new client_token
     *
     * @return string
     */
    private function mintClientToken($request) {
        $options = [
            'headers' => $this->headers,
            'form_params' => [
                'grant_type' => 'client_credentials',
                'scope' => 'https://api.ebay.com/oauth/api_scope'
            ]
        ];

        try {
            $response = $this->client->post('https://api.sandbox.ebay.com/identity/v1/oauth2/token', $options);
            $token = json_decode($response->getBody()->getContents());

            $minted_token = $this->saveClientTokenToDB($token);
            $this->saveClientTokenToSession($request, $minted_token);

        } catch (RequestException $e) {
            print_r(json_decode($e->getResponse()->getBody()->getContents()));
            die();
        }
    }

    /**
     * Saves or updates a token to the DB
     *
     * @return void
     */
    private function saveClientTokenToDB($token) {
        if(!$config = Config::first()){
            $config = new Config;
        }

        $config->client_token = $token->access_token;
        $config->client_token_expires_at = Carbon::now()->addSeconds($token->expires_in);
        $config->client_token_type = $token->token_type;
        $config->save();

        return $config;
    }

    /**
     * Saves or updates a token to the session
     *
     * @return void
     */
    private function saveUserTokenToSession($request, $token) {
        // Store token in the session
        $request->session()->put('client_token', $token->client_token);
        $request->session()->put('client_token_expires_at', $token->expires_at);
    }
}
