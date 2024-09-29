<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.user.user_management', ['s' => $request->s]);
    }

    public function administrator(Request $request)
    {
        return view('pages.user.admin_management', ['s' => $request->s]);
    }

    public function personalization()
    {
        return view('pages.user.personalization');
    }
}
