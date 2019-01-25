<?php

namespace App\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Facades\App\Classes\eBayAPI\GetSessionID;
use Facades\App\Classes\eBayAPI\FetchToken;

class Token {

    private $signinURL;
    private $RUName;

    public function __construct() {
        // Construct the signinURL
        if(env('APP_ENV') == 'production') {
            $this->signinURL = 'https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&';
        }

        if(env('APP_ENV') == 'sandbox') {
            $this->signinURL = 'https://signin.sandbox.ebay.com/ws/eBayISAPI.dll?SignIn&';
        }

        $this->signinURL .= 'RUName=' . env('EBAY_RUNAME') . '&SessID=';
    }

    /*
     *      validate
     *      Forwards the validation request to the appropriate method
     */
    public function validate(String $tokenType, Request $request) {
        if($tokenType == 'client') {
            $this->validateClientToken($request);
        }

        if($tokenType == 'user') {
            $this->validateUserToken();
        }

        return true;
    }

    public function accept() {
        $token = FetchToken::handle();
        print_r($token); die();
    }

    private function validateClientToken(Request $request) {
        $session = $request->session();
        // Client token does not exist in session OR expires within 30min
        if($session->has('client_token')) {
            print_r($session->get('client_token')); die();
        } else {
            // Mint a new client token
            $this->mintClientToken($request);
        }
    }

    private function validateUserToken() {
        // User token does not exist in session OR expires within 30min
            // Mint a new user token
    }

    private function mintClientToken(Request $request) {
        $sessionID = GetSessionID::handle($request);
        $this->signinURL .= $sessionID;

        echo Redirect::away($this->signinURL);
        die();
        // Accept incoming request at the AcceptURL
        // Request token using the session ID
        // Store newly minted token in the DB and session
    }

}
