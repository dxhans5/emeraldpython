<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Config;
use Carbon\Carbon;

class RegisterUserTokenController extends Controller
{
    /**
     * Constructor...limits access to authenticated users
     */
    public function __construct() {
        // Setup the Guzzle client
        $this->client = new Client();
    }

    /**
     * Registers a user token to the system
     */
    public function register(Request $request) {
        if($request->input('state') == 'jadepython') {
            $code = $request->input('code');

            $options = [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(env('EBAY_CREDS')),
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri'=> env('EBAY_RUNAME')
                ]
            ];

            $response = $this->client->post(env('EBAY_DOMAIN') . '/identity/v1/oauth2/token', $options);
            $token = json_decode($response->getBody()->getContents());

            $minted_token = $this->saveUserTokenToDB($token);
            $this->saveUserTokenToSession($request, $minted_token);

            return redirect('/admin');

        } else {
            $request->session()->flash('errors', $response);
            return view('admin.dashboard');
        }
    }

    /**
     * Saves or updates a token to the DB
     *
     * @return void
     */
    private function saveUserTokenToDB($token) {
        if(!$config = Config::first()){ $config = new Config; }

        $config->user_token = $token->access_token;
        $config->user_token_expires_at = Carbon::now()->addSeconds($token->expires_in);
        $config->user_refresh_token = $token->refresh_token;
        $config->user_token_type = $token->token_type;
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
        $request->session()->put('user_token', $token->user_token);
        $request->session()->put('user_token_expires_at', $token->user_token_expires_at);
    }
}
