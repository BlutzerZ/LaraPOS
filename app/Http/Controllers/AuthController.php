<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login()
    {
        return view('auth.login');
    }  

    function register()
    {
        return view('auth.register');
    }

    function loginProcess()
    {
        // 
        return view('auth.login');
    }

    function registerProcess()
    {
        // 
        return view('auth.register');
    }
}
