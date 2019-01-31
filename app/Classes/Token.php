<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Facades\App\Classes\eBayAPI\GetSessionID;
use Facades\App\Classes\eBayAPI\FetchToken;
use Facades\App\Models\Config;

class Token {

    private $signinURL;
    private $RUName;
    private $config;

    /*
     *      __construct
     *      Class constructor
     */
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
        $config = Config::getFirst();

        if($session->has('user_token')) {
            return true;
        } else {
            if(!$this->tokenExpiresSoon($config)) {
                // add the token to the session
                $request->session()->put(['user_token' => $config->user_token, 'user_token_expires_at' => $config->user_token_expires_at]);
                return true;
            } else {
                // Mint a new token
                $this->mintToken($request);
            }
        }

        return false;
    }

    /*
     *      accept
     *      Accepts the token from eBay
     */
    public function accept(Request $request) {
        $token = FetchToken::handle();
        $userToken = $token['user_token'];
        $tokenExpiration = $token['user_token_expires_at']; // TODO: Convert this to a carbon timestamp

        // save the token and expiration date
        $this->config->user_token = $userToken;
        $this->config->user_token_expires_at = $this->convertToNormalTime($tokenExpiration);
        $this->config->save();

        // add the token to the session
        $request->session()->put(['user_token' => $userToken, 'user_token_expires_at' => $tokenExpiration]);

        return true;
    }

    /*
     *      mintToken
     *      Creates the url needed to sign into eBay for third party acceptance
     *      Redirects user out to the external sign in for eBay
     */
    private function mintToken(Request $request) {
        $sessionID = GetSessionID::handle($request);
        $this->signinURL .= $sessionID;

        echo Redirect::away($this->signinURL);
        die(); // This will redirect away to eBay login page
    }

    /*
    *       convertToNormalTime
    *       Updates the weird datestamp format that is received from eBay to something more useful
    */
    private function convertToNormalTime(String $timestamp) {
        $explodedTimestamp = explode(' ', preg_replace('/[\.T]/', ' ', $timestamp));
        $date = $explodedTimestamp[0];
        $time = $explodedTimestamp[1];
        $zone = $explodedTimestamp[2];

        return $date . ' ' . $time;
    }

    /*
     *      tokenExpiresSoon
     *      Determines if the token will expire within an hour or less
     */
    private function tokenExpiresSoon($config) {
        $start = Carbon::now();
        $end = Carbon::parse($config->user_token_expires_at);

        if($start->diffInSeconds($end) <= 3600) { // Token expires in an hour or less
           return true;
        }

        return false;
    }

}
