<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login() {
        return view('login.login');
    }

    public function register(){
        return view('login.register');
    }

    public function auth(Request $request) {

        $valideted = $request->validate([
            'email' => ['string', 'required', 'email'],
            'name' => ['string', 'required', 'min:5', 'max:50'],
            'password' => ['string', 'required', 'min:5', 'max:50'],
        ]);


        if (Auth::attempt($valideted)) {
            return redirect()->route('groups.index');
        }
    }
}
