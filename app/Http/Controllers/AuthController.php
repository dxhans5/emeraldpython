<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Facades\App\Classes\Token;

class AuthController extends Controller
{

    public function login(Request $request) {
        $session = $request->session();

        if($request->isMethod('post')) {
            // POST
            $email = $this->sanitize($request->get('email'));
            $password = $this->sanitize($request->get('password'));
            $authenticated = $this->authenticate($email, $password);

            if($authenticated) {
                Token::validate($request);
                print_r($request->session()->all()); die();
            }

            // TODO: Add a flash with errors.
            return Redirect::to('/login');
        } else {
            // GET
            if($request->session()->get('user_token')) {
                print_r($this)
            }

            return view('auth.login');
        }
    }

    /*
     *      logout
     *      Logs out a user, and flushes the users session.
     *      Redirects to the login screen.
     */
    public function logout(Request $request) {
        Auth::logout();
        Session::flush();
        return Redirect::to('/login');
    }

    /*
     *      registerToken
     *      Calls into the Token object to register the newly minted token
     */
    public function registerToken(Request $request) {
        Token::accept($request);

        // Send back to the login page to finish the authentication process
        return Redirect::to('/login');
    }

    /*
     *      authenticate
     *      Authenticates a user with their email and password.
     *      Returns a boolean.
     */
    private function authenticate(String $email, String $password) {
        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        return Auth::attempt($credentials);
    }
}
