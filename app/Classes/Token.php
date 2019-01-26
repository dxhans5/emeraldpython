<?php

namespace App\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Facades\App\Classes\eBayAPI\GetSessionID;
use Facades\App\Classes\eBayAPI\FetchToken;
use Facades\App\Models\Config;

class Token {

    private $signinURL;
    private $RUName;
    private $config;

    public function __construct() {
        // Construct the signinURL
        if(env('APP_ENV') == 'production') {
            $this->signinURL = 'https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&';
        }

        if(env('APP_ENV') == 'sandbox') {
            $this->signinURL = 'https://signin.sandbox.ebay.com/ws/eBayISAPI.dll?SignIn&';
        }

        $this->signinURL .= 'RUName=' . env('EBAY_RUNAME') . '&SessID=';
        $this->config = Config::getFirst();
    }

    /*
     *      validate
     *      Forwards the validation request to the appropriate method
     */
    public function validate(Request $request) {
        $session = $request->session();

        if($session->has('user_token') || !empty(Config::getFirst())) {
            return true;
        } else {
            // Mint a new token
            $this->mintToken($request);
        }

        return false;
    }

    public function accept(Request $request) {
        $token = FetchToken::handle();
        $userToken = $token['user_token'];
        $tokenExpiration = $token['user_token_expires_at'];

        // save the token and expiration date
        $this->config->user_token = $userToken;
        $this->config->user_token_expires_at = $tokenExpiration;
        $this->config->save();

        // add the token to the session
        $request->session()->put(['user_token' => $userToken, 'user_token_expires_at' => $tokenExpiration]);

        return true;
    }

    private function mintToken(Request $request) {
        $sessionID = GetSessionID::handle($request);
        $this->signinURL .= $sessionID;

        echo Redirect::away($this->signinURL);
        die(); // This will redirect away to eBay login page
    }

}
