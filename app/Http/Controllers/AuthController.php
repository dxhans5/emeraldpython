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
        if($request->isMethod('post')) {
            // POST
            $email = $this->sanitize($request->get('email'));
            $password = $this->sanitize($request->get('password'));
            $authenticated = $this->authenticate($email, $password);

            if($authenticated) {
                Token::validate('client', $request);
                // User Token

                // Login user
                // Redirect to dashboard
            }

            // TODO: Add a flash with errors.
            return Redirect::to('/login');
        } else {
            // GET
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

    public function registerToken() {
        Token::accept();
        die();
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
