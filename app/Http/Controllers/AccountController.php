<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Préférences du compte.
 */
class AccountController extends Controller
{
    public function index()
    {
        return view('account');
    }
}
